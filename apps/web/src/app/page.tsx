const pillars = [
  "Property",
  "Stays",
  "Vehicles",
  "Events",
  "SME Food & Services",
  "Tours & Experiences",
  "Home & Beauty Services"
];

export default function HomePage() {
  return (
    <main className="min-h-screen px-6 py-12 md:px-12">
      <section className="hero-glass mx-auto max-w-6xl rounded-3xl p-8 shadow-2xl md:p-14">
        <p className="mb-3 text-sm tracking-[0.2em] text-[#0A2540]/75">PEARLHUB 2.0</p>
        <h1 className="font-display text-4xl text-[#0A2540] md:text-6xl">
          Sri Lanka&apos;s Most Trusted Luxury Multi-Vertical Marketplace
        </h1>
        <p className="mt-6 max-w-3xl text-lg text-[#102A43]">
          Escrow-first commerce, AI concierge booking, verified providers, and premium customer
          experiences across every major lifestyle vertical.
        </p>
        <div className="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
          {pillars.map((pillar) => (
            <div
              key={pillar}
              className="rounded-xl border border-[#D4AF77]/40 bg-white/80 px-4 py-3 text-sm font-semibold text-[#0A2540]"
            >
              {pillar}
            </div>
          ))}
        </div>
      </section>
    </main>
  );
}
