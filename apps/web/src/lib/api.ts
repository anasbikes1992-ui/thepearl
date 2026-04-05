import { z } from "zod";

const ListingSchema = z.object({
  id: z.string(),
  title: z.string(),
  vertical: z.string(),
  district: z.string(),
  city: z.string(),
  base_price: z.string().or(z.number())
});

export type ListingCard = z.infer<typeof ListingSchema>;

export async function fetchListings(): Promise<ListingCard[]> {
  const base = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1";
  const res = await fetch(`${base}/listings`, { cache: "no-store" });

  if (!res.ok) {
    return [];
  }

  const payload = await res.json();
  const data = payload?.data?.data ?? [];

  return z.array(ListingSchema).catch([]).parse(data);
}
