{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Redirecting to Checkout...</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      background: #0a0f24;
      font-family: 'Inter', sans-serif;
      color: #e8ecff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .loading-container {
      text-align: center;
      max-width: 400px;
      padding: 40px;
    }
    
    .spinner {
      width: 50px;
      height: 50px;
      border: 3px solid rgba(96,116,255,0.2);
      border-top-color: #6074ff;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      margin: 0 auto 20px;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    h2 {
      font-size: 20px;
      font-weight: 500;
      margin-bottom: 10px;
    }
    
    p {
      color: #8f9abf;
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="loading-container">
  <div class="spinner"></div>
  <h2>Redirecting to Secure Checkout</h2>
  <p>Please wait while we prepare your payment...</p>
</div>

<script>
  const urlParams = new URLSearchParams(window.location.search);
  const plan = urlParams.get('plan');
  
  if (!plan || (plan !== 'web' && plan !== 'full')) {
    window.location.href = '/pricing';
  }
  
  // Create form and submit to existing checkout route
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/checkout/${plan}`;
  
  // Add CSRF token
  const csrfInput = document.createElement('input');
  csrfInput.type = 'hidden';
  csrfInput.name = '_token';
  csrfInput.value = '{{ csrf_token() }}';
  form.appendChild(csrfInput);
  
  document.body.appendChild(form);
  
  // Submit form to get Stripe Checkout URL
  fetch(form.action, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ tier: plan })
  })
  .then(response => response.json())
  .then(data => {
    if (data.checkout_url) {
      window.location.href = data.checkout_url;
    } else {
      alert('Error: ' + (data.error || 'Could not create checkout session'));
      window.location.href = '/pricing';
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Something went wrong. Please try again.');
    window.location.href = '/pricing';
  });
</script>
</body>
</html> --}}