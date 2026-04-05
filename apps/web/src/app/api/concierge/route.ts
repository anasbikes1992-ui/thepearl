import { NextRequest, NextResponse } from "next/server";
import { z } from "zod";

const ConciergeSchema = z.object({
  message: z.string().min(2).max(2000),
  locale: z.enum(["en", "si", "ta"]).default("en")
});

export async function POST(request: NextRequest) {
  const body = await request.json();
  const parsed = ConciergeSchema.safeParse(body);

  if (!parsed.success) {
    return NextResponse.json({ error: "Invalid concierge input" }, { status: 422 });
  }

  // Phase 3: proxy to Laravel AI concierge orchestration endpoint.
  return NextResponse.json({
    reply: "Concierge received your request. AI orchestration wiring starts in Phase 3.",
    input: parsed.data
  });
}
