<link rel="shortcut icon" href="{{ asset('icon/logo2.png') }}" type="image/png">
<script src="https://cdn.tailwindcss.com"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  
    .animate-fade-in {
      animation: fadeIn 1s ease-out forwards;
    }

    @keyframes loading-bar {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .animate-loading-bar {
      animation: loading-bar 1.5s linear infinite;
    }
  </style>