export default function ProviderConsolePage() {
  return (
    <main className="mx-auto min-h-screen w-full max-w-5xl px-6 py-12 md:px-10">
      <h1 className="font-display text-4xl text-[#0A2540]">Provider Console</h1>
      <div className="mt-8 grid gap-4 md:grid-cols-3">
        <div className="rounded-2xl border border-[#D4AF77]/40 bg-white/80 p-5">
          <p className="text-sm text-[#0A2540]/70">Pending Listings</p>
          <p className="mt-2 text-3xl font-semibold text-[#0A2540]">0</p>
        </div>
        <div className="rounded-2xl border border-[#D4AF77]/40 bg-white/80 p-5">
          <p className="text-sm text-[#0A2540]/70">Held Escrow</p>
          <p className="mt-2 text-3xl font-semibold text-[#0A2540]">LKR 0</p>
        </div>
        <div className="rounded-2xl border border-[#D4AF77]/40 bg-white/80 p-5">
          <p className="text-sm text-[#0A2540]/70">Subscription Tier</p>
          <p className="mt-2 text-3xl font-semibold text-[#0A2540]">Free</p>
        </div>
      </div>
    </main>
  );
}
