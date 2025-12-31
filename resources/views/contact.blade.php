@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="container mx-auto px-4 py-12 max-w-3xl">
  <h1 class="text-5xl font-bold text-center text-white mb-12">Contact Our TZ Team</h1>

  <div class="grid md:grid-cols-2 gap-10">
    <div>
      <h3 class="text-xl font-semibold text-blue-400 mb-4">Quick Support</h3>
      <p class="text-slate-300 mb-6">We're available 24/7 via WhatsApp, SMS, or email.</p>
      <div class="space-y-4">
        <div class="flex gap-3"><strong>WhatsApp:</strong> <a href="https://wa.me/255768000111" class="text-green-400">+255 768 000 111</a></div>
        <div class="flex gap-3"><strong>Email:</strong> <a href="mailto:support@hardwaretz.co" class="text-blue-400">support@hardwaretz.co</a></div>
        <div class="flex gap-3"><strong>Offices:</strong> Dar es Salaam | Dodoma | Arusha</div>
      </div>
    </div>
    <form class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-2xl p-6">
      <input type="text" placeholder="Your Name" class="w-full mb-4 p-3 bg-slate-700 rounded-lg text-white placeholder-slate-400">
      <input type="email" placeholder="Email" class="w-full mb-4 p-3 bg-slate-700 rounded-lg text-white placeholder-slate-400">
      <textarea placeholder="Message" rows="4" class="w-full mb-4 p-3 bg-slate-700 rounded-lg text-white placeholder-slate-400"></textarea>
      <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">Send Message</button>
    </form>
  </div>
</div>