export function StatCard({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-2xl border border-[#D4AF77]/30 bg-white/80 p-5 shadow-sm">
      <p className="text-xs uppercase tracking-[0.18em] text-[#0A2540]/55">{label}</p>
      <p className="mt-3 text-3xl font-semibold text-[#0A2540]">{value}</p>
    </div>
  );
}
