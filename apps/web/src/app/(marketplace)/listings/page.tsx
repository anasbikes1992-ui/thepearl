import { ListingGrid } from "@/components/sections/listing-grid";
import { fetchListings } from "@/lib/api";

export default async function ListingsPage() {
  const listings = await fetchListings();

  return (
    <main className="mx-auto min-h-screen w-full max-w-6xl px-6 py-12 md:px-10">
      <h1 className="font-display text-4xl text-[#0A2540]">Published Listings</h1>
      <p className="mt-3 text-[#102A43]">
        Browse premium verified providers across all seven PearlHub verticals.
      </p>
      <section className="mt-8">
        <ListingGrid listings={listings} />
      </section>
    </main>
  );
}
