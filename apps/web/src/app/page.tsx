import { FeatureCard } from "@/components/cards/feature-card";
import { StatCard } from "@/components/cards/stat-card";
import { SiteHeader } from "@/components/layout/site-header";

const pillars = [
  "Property",
  "Stays",
  "Vehicles",
  "Events",
  "SME Food & Services",
  "Tours & Experiences",
  "Home & Beauty Services",
  "Resale"
];

const features = [
  {
    title: "Agentic Concierge",
    body: "Plan complex cross-vertical journeys with AI memory, voice entrypoints, and booking-aware recommendations."
  },
  {
    title: "Escrow 2.0",
    body: "Automatic hold, release, dispute, payout, and reconciliation logic built for trusted premium commerce."
  },
  {
    title: "Livestream Commerce",
    body: "Provider-led live sessions, social engagement loops, and instant shopping surfaces tuned for mobile-first markets."
  },
  {
    title: "Pearl Academy",
    body: "Training, certification, and provider quality uplift tied to badges, loyalty, and growth enablement."
  },
  {
    title: "Resale + Sustainability",
    body: "Second-life premium inventory, eco-badges, and sustainability scoring layered into the marketplace model."
  },
  {
    title: "Platform Ready",
    body: "REST now, GraphQL-ready, event-ledger capable, and tenant-aware for future regional expansion."
  }
];

export default function HomePage() {
  return (
    <main className="min-h-screen px-6 py-8 md:px-12">
      <div className="mx-auto max-w-6xl">
        <SiteHeader />

        <section className="hero-glass mt-6 overflow-hidden rounded-[2rem] p-8 shadow-2xl md:p-14">
          <div className="grid gap-10 lg:grid-cols-[1.3fr_0.7fr] lg:items-end">
            <div>
              <p className="mb-3 text-sm tracking-[0.2em] text-[#0A2540]/75">PEARLHUB 2.0</p>
              <h1 className="font-display text-5xl leading-tight text-[#0A2540] md:text-7xl">
                Sri Lanka&apos;s Premium AI-Native Marketplace Super-App
              </h1>
              <p className="mt-6 max-w-3xl text-lg leading-8 text-[#102A43]">
                Escrow-first commerce, verified providers, social discovery, voice booking,
                livestreams, resale, academy, and multi-vertical trust infrastructure built into one
                luxury platform.
              </p>
              <div className="mt-8 flex flex-wrap gap-3">
                <a href="/listings" className="rounded-full bg-[#0A2540] px-6 py-3 text-sm font-semibold text-white">
                  Explore Marketplace
                </a>
                <a href="/provider" className="rounded-full border border-[#0A2540]/20 bg-white/70 px-6 py-3 text-sm font-semibold text-[#0A2540]">
                  Become a Provider
                </a>
              </div>
            </div>

            <div className="grid gap-4">
              <StatCard label="Verticals" value="8" />
              <StatCard label="Core Revenue Streams" value="7" />
              <StatCard label="Languages" value="EN / SI / TA" />
            </div>
          </div>

          <div className="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
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

        <section className="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
          {features.map((feature) => (
            <FeatureCard key={feature.title} title={feature.title} body={feature.body} />
          ))}
        </section>
      </div>
    </main>
  );
}
