<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stem;
use App\Models\Download;
use App\Models\Purchase;
use App\Models\EmailJob;
use App\Models\AdminAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ============================================
    // VIEWS
    // ============================================
    
    public function index()
    {
        return view('partials.admin');
    }
    
    // ============================================
    // DASHBOARD STATS
    // ============================================
    
    public function stats()
    {
        return response()->json([
            'total_stems' => Stem::count(),
            'visible_stems' => Stem::where('is_visible', true)->count(),
            'hidden_stems' => Stem::where('is_visible', false)->count(),
            'total_users' => User::count(),
            'free_users' => User::where('plan_tier', 'free')->count(),
            'web_users' => User::where('plan_tier', 'web')->count(),
            'full_users' => User::where('plan_tier', 'full')->count(),
            'downloads_today' => Download::whereDate('downloaded_at', today())->count(),
            'revenue_today' => Purchase::whereDate('purchased_at', today())
                ->where('status', 'completed')->sum('amount'),
            'total_revenue' => Purchase::where('status', 'completed')->sum('amount'),
        ]);
    }
    
    // ============================================
    // STEMS MANAGEMENT
    // ============================================
    
    public function stems(Request $request)
    {
        $query = Stem::query();
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('artist', 'like', '%' . $request->search . '%')
                  ->orWhere('genre', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by type
        if ($request->stem_type) {
            $query->where('stem_type', $request->stem_type);
        }
        
        // Filter by visibility
        if ($request->visibility !== null && $request->visibility !== '') {
            $query->where('is_visible', $request->visibility === 'visible');
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'bpmAsc':
                $query->orderBy('bpm', 'asc');
                break;
            case 'bpmDesc':
                $query->orderBy('bpm', 'desc');
                break;
            case 'type':
                $query->orderBy('stem_type', 'asc');
                break;
            default:
                $query->latest();
        }
         $perPage = $request->get('per_page', 50);
        $stems = $query->paginate($perPage);
        
        return response()->json($stems);
    }
    
    public function getStem(Stem $stem)
    {
        return response()->json($stem);
    }
    
    public function updateStem(Request $request, Stem $stem)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'artist' => 'required|string|max:100',
            'stem_type' => 'required|string|in:Acapella,Drums,Bass,Melody,Instrumental',
            'bpm' => 'required|integer|min:40|max:220',
            'musical_key' => 'required|string|max:10',
            'genre' => 'required|string|max:50',
        ]);
        
        $oldData = $stem->toArray();
        $stem->update($request->only(['title', 'artist', 'stem_type', 'bpm', 'musical_key', 'genre']));
        
        // Audit log
        $this->auditLog('edit_stem', 'stem', $stem->id, [
            'old' => $oldData,
            'new' => $stem->toArray()
        ]);
        
        return response()->json(['success' => true, 'stem' => $stem, 'message' => 'Stem updated successfully']);
    }
    
    public function toggleVisibility(Stem $stem)
    {
        $stem->update(['is_visible' => !$stem->is_visible]);
        
        $this->auditLog('toggle_visibility', 'stem', $stem->id, [
            'new_visibility' => $stem->is_visible
        ]);
        
        return response()->json([
            'success' => true, 
            'is_visible' => $stem->is_visible,
            'message' => $stem->is_visible ? 'Stem is now visible' : 'Stem is now hidden'
        ]);
    }
    
    public function bulkVisibility(Request $request)
    {
        $request->validate([
            'stem_ids' => 'required|array',
            'action' => 'required|in:hide,unhide'
        ]);
        
        $visible = $request->action === 'unhide';
        $count = Stem::whereIn('id', $request->stem_ids)->update(['is_visible' => $visible]);
        
        $this->auditLog('bulk_visibility', 'stem', null, [
            'action' => $request->action,
            'stem_ids' => $request->stem_ids,
            'count' => $count
        ]);
        
        return response()->json([
            'success' => true, 
            'count' => $count,
            'message' => $count . ' stems ' . ($visible ? 'unhidden' : 'hidden')
        ]);
    }
    
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'stem_ids' => 'required|array'
        ]);
        
        $count = Stem::whereIn('id', $request->stem_ids)->delete();
        
        $this->auditLog('bulk_delete', 'stem', null, [
            'stem_ids' => $request->stem_ids,
            'count' => $count
        ]);
        
        return response()->json(['success' => true, 'count' => $count]);
    }
    
    // ============================================
    // CUSTOMERS MANAGEMENT
    // ============================================
    
    public function customers(Request $request)
    {
        $query = User::query();
        $query->where(function ($q) {
    $q->whereNull('role')
      ->orWhere('role', '!=', 'admin');
});
        
        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by tier
        if ($request->tier && $request->tier !== 'all') {
            $query->where('plan_tier', $request->tier);
        }
        
        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
              $perPage = $request->get('per_page', 50);
        $customers = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        // Transform data for frontend
        $customers->through(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'plan_tier' => $user->plan_tier,
                'status' => $user->status,
                'joined' => $user->created_at->format('Y-m-d'),
                'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never',
                'downloads_count' => $user->downloads()->count(),
                'purchases_count' => $user->purchases()->count(),
            ];
        });
        
        
        return response()->json($customers);
    }
    
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'plan_tier' => $user->plan_tier,
            'status' => $user->status,
            'joined' => $user->created_at->format('Y-m-d'),
            'last_login' => $user->last_login_at,
            'downloads' => $user->downloads()->count(),
            'purchases' => $user->purchases()->get(),
        ]);
    }
    
    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,banned,suspended'
        ]);
        
        $oldStatus = $user->status;
        $user->update(['status' => $request->status]);
        
        // If banning, set banned_until
        if ($request->status === 'banned') {
            $user->update(['banned_until' => now()->addDays(30)]);
        } else {
            $user->update(['banned_until' => null]);
        }
        
        $this->auditLog('update_user_status', 'user', $user->id, [
            'old_status' => $oldStatus,
            'new_status' => $request->status
        ]);
        
        return response()->json(['success' => true, 'message' => 'User status updated']);
    }
    
    public function updateUserTier(Request $request, User $user)
    {
        $request->validate([
            'plan_tier' => 'required|in:free,web,full'
        ]);
        
        $oldTier = $user->plan_tier;
        $user->update(['plan_tier' => $request->plan_tier]);
        
        $this->auditLog('update_user_tier', 'user', $user->id, [
            'old_tier' => $oldTier,
            'new_tier' => $request->plan_tier
        ]);
        
        return response()->json(['success' => true, 'message' => 'User tier updated']);
    }
    
    public function resetUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8'
        ]);
        
        $user->update(['password_hash' => Hash::make($request->password)]);
        
        $this->auditLog('reset_password', 'user', $user->id, [
            'reset_by_admin' => auth()->id()
        ]);
        
        return response()->json(['success' => true, 'message' => 'Password reset successfully']);
    }
    
    // ============================================
    // BULK EMAIL
    // ============================================
    
   public function sendEmail(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:200',
        'message' => 'required|string',
        'user_ids' => 'required|array',
    ]);

    $users = User::whereIn('id', $request->user_ids)->get();
    $sent = 0;
    $failed = 0;

    foreach ($users as $user) {
        try {
            Mail::raw($request->message, function ($mail) use ($user, $request) {
                $mail->to($user->email)
                     ->subject($request->subject)
                     ->from(config('mail.from.address'), 'Son Got Samples');
            });
            $sent++;
        } catch (\Exception $e) {
            $failed++;
            \Log::error('Email failed to ' . $user->email . ': ' . $e->getMessage());
        }
    }

    // Save email job record
    \App\Models\EmailJob::create([
        'subject' => $request->subject,
        'body' => $request->message,
        'recipient_scope' => $request->user_ids,
        'created_by' => auth()->id(),
        'status' => 'completed',
        'sent_count' => $sent,
        'failed_count' => $failed
    ]);

    return response()->json([
        'success' => true,
        'message' => "Email sent to $sent users" . ($failed ? ". Failed: $failed" : "")
    ]);
}
    
    public function emailJobs()
    {
        $jobs = EmailJob::with('creator')->orderBy('created_at', 'desc')->paginate(20);
        return response()->json($jobs);
    }
    
    // ============================================
    // AUDIT LOGS
    // ============================================
    
public function auditLogs(Request $request)
{
    $query = AdminAuditLog::with('admin')->orderBy('created_at', 'desc');
    
    if ($request->action_type) {
        $query->where('action_type', $request->action_type);
    }
    
    $logs = $query->paginate(50);
    
    // Transform data for frontend
    $logs->through(function($log) {
        return [
            'id' => $log->id,
            'admin' => $log->admin ? [
                'id' => $log->admin->id,
                'name' => $log->admin->name,
                'email' => $log->admin->email
            ] : null,
            'action_type' => $log->action_type,
            'target_type' => $log->target_type,
            'target_id' => $log->target_id,
            'details' => $log->details,
            'created_at' => $log->created_at->toISOString()
        ];
    });
    
    return response()->json($logs);
}
    
    // ============================================
    // DOWNLOADS REPORT
    // ============================================
    
    public function downloadsReport(Request $request)
    {
        $query = Download::with(['user', 'stem']);
        
        if ($request->start_date) {
            $query->whereDate('downloaded_at', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('downloaded_at', '<=', $request->end_date);
        }
        
        $downloads = $query->orderBy('downloaded_at', 'desc')->paginate(50);
        
        return response()->json($downloads);
    }
    
    // ============================================
    // HELPER FUNCTIONS
    // ============================================
    
    private function auditLog($action, $targetType, $targetId, $details = [])
    {
        AdminAuditLog::create([
            'admin_user_id' => auth()->id(),
            'action_type' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'details' => $details
        ]);
    }

    // Update customer (name, email, tier, status)
public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'plan_tier' => 'required|in:free,web,full',
        'status' => 'required|in:active,banned,suspended'
    ]);
    
    $oldData = $user->toArray();
    
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'plan_tier' => $request->plan_tier,
        'status' => $request->status
    ]);
    
    // Audit log
    $this->auditLog('update_user', 'user', $user->id, [
        'old' => $oldData,
        'new' => $user->toArray()
    ]);
    
    return response()->json([
        'success' => true, 
        'message' => 'Customer updated successfully',
        'user' => $user
    ]);
}

 public function importCsv(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|max:10240', // max 10MB — no mimes check (browser sends wrong MIME for CSV)
        ]);
 
        // Manual extension check (more reliable than mimes validation)
        $originalName = $request->file('csv')->getClientOriginalName();
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'txt'])) {
            return response()->json(['success' => false, 'message' => 'Please upload a .csv file'], 422);
        }
 
        $file   = $request->file('csv');
        $handle = fopen($file->getRealPath(), 'r');
 
        if (!$handle) {
            return response()->json(['success' => false, 'message' => 'Cannot read uploaded file'], 422);
        }
 
        // Strip UTF-8 BOM if present (Excel exports often include it)
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }
 
        // Parse header row
        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return response()->json(['success' => false, 'message' => 'CSV file is empty or has no header row'], 422);
        }
 
        // Normalize headers
        $headers = array_map(fn($h) => strtolower(trim(preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/u', '', $h))), $headers);
 
        if (!in_array('email', $headers)) {
            fclose($handle);
            return response()->json([
                'success' => false,
                'message' => 'CSV must have an "email" column. Columns found: ' . implode(', ', $headers),
            ], 422);
        }
 
        // Column index map
        $col = [
            'email'  => array_search('email',  $headers),
            'name'   => array_search('name',   $headers),
            'tier'   => array_search('plan_tier', $headers) !== false
                            ? array_search('plan_tier', $headers)
                            : array_search('tier', $headers),
            'status' => array_search('status', $headers),
        ];
 
        $validTiers    = ['free', 'web', 'full'];
        $validStatuses = ['active', 'banned', 'suspended'];
 
        $imported = 0;
        $skipped  = 0;
        $failed   = 0;
        $errors   = [];
        $rowNum   = 1;
 
        // Batch-check existing emails for performance (load all into memory)
        // For very large CSVs we check per-row to stay safe
        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
 
            // Skip blank rows
            if (empty(array_filter(array_map('trim', $row)))) {
                continue;
            }
 
            $email = isset($row[$col['email']]) ? strtolower(trim($row[$col['email']])) : '';
 
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $failed++;
                $errors[] = "Row $rowNum: invalid email '{$email}'";
                continue;
            }
 
            // Skip duplicates
            if (User::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }
 
            $name = ($col['name'] !== false && isset($row[$col['name']]))
                        ? trim($row[$col['name']])
                        : Str::before($email, '@');
 
            $tier = ($col['tier'] !== false && isset($row[$col['tier']]))
                        ? strtolower(trim($row[$col['tier']]))
                        : 'free';
            if (!in_array($tier, $validTiers)) $tier = 'free';
 
            $status = ($col['status'] !== false && isset($row[$col['status']]))
                        ? strtolower(trim($row[$col['status']]))
                        : 'active';
            if (!in_array($status, $validStatuses)) $status = 'active';
 
            try {
                $userData = [
                    'name'              => $name ?: Str::before($email, '@'),
                    'email'             => $email,
                    'password'          => Hash::make(Str::random(16)),
                    'plan_tier'         => $tier,
                    'status'            => $status,
                    'email_verified_at' => now(),
                ];
 
                // Only set is_admin if the column exists in users table
                try {
                    $userData['is_admin'] = false;
                    User::create($userData);
                } catch (\Exception $colErr) {
                    // is_admin column may not exist — retry without it
                    unset($userData['is_admin']);
                    User::create($userData);
                }
 
                $imported++;
            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Row $rowNum ($email): " . $e->getMessage();
            }
        }
 
        fclose($handle);
 
        // Audit log
        $this->auditLog('import_csv', 'user', null, [
            'imported' => $imported,
            'skipped'  => $skipped,
            'failed'   => $failed,
        ]);
 
        return response()->json([
            'success'  => true,
            'imported' => $imported,
            'skipped'  => $skipped,
            'failed'   => $failed,
            'errors'   => array_slice($errors, 0, 20), // cap at 20 error messages
            'message'  => "Import complete — {$imported} imported, {$skipped} skipped (already exist), {$failed} failed.",
        ]);
    }

    public function deleteUser(User $user)
{
    try {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Delete failed: ' . $e->getMessage()], 500);
    }
}
}