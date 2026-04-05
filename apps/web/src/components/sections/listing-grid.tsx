import type { ListingCard } from "@/lib/api";

export function ListingGrid({ listings }: { listings: ListingCard[] }) {
  if (listings.length === 0) {
    return (
      <div className="rounded-2xl border border-[#0A2540]/10 bg-white/80 p-8 text-center text-[#0A2540]/70">
        No listings published yet.
      </div>
    );
  }

  return (
    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      {listings.map((listing) => (
        <article
          key={listing.id}
          className="rounded-2xl border border-[#D4AF77]/40 bg-white/85 p-5 shadow-sm"
        >
          <p className="text-xs uppercase tracking-[0.18em] text-[#0A2540]/60">{listing.vertical}</p>
          <h3 className="mt-1 text-xl font-semibold text-[#0A2540]">{listing.title}</h3>
          <p className="mt-2 text-sm text-[#102A43]">
            {listing.city}, {listing.district}
          </p>
          <p className="mt-3 text-lg font-bold text-[#0A2540]">LKR {listing.base_price}</p>
        </article>
      ))}
    </div>
  );
}
