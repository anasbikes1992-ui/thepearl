export function FeatureCard({ title, body }: { title: string; body: string }) {
  return (
    <article className="rounded-3xl border border-[#0A2540]/8 bg-[linear-gradient(180deg,rgba(255,255,255,0.92),rgba(248,241,227,0.84))] p-6 shadow-sm">
      <h3 className="font-display text-2xl text-[#0A2540]">{title}</h3>
      <p className="mt-3 text-sm leading-6 text-[#102A43]">{body}</p>
    </article>
  );
}
