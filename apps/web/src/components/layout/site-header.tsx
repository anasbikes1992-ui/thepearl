const navItems = [
  { href: '/listings', label: 'Listings' },
  { href: '/livestreams', label: 'Live' },
  { href: '/academy', label: 'Academy' },
  { href: '/resale', label: 'Resale' },
  { href: '/voice', label: 'Voice' }
];

export function SiteHeader() {
  return (
    <header className="mx-auto flex w-full max-w-6xl items-center justify-between rounded-full border border-[#D4AF77]/35 bg-white/75 px-5 py-4 shadow-sm backdrop-blur">
      <div>
        <p className="text-xs tracking-[0.24em] text-[#0A2540]/60">PEARLHUB</p>
        <p className="font-display text-2xl text-[#0A2540]">Book Anything, Trust Everything</p>
      </div>
      <nav className="hidden items-center gap-5 md:flex">
        {navItems.map((item) => (
          <a key={item.href} href={item.href} className="text-sm font-semibold text-[#0A2540]/80 transition hover:text-[#0A2540]">
            {item.label}
          </a>
        ))}
      </nav>
    </header>
  );
}
