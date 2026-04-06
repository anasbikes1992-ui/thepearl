import type { Metadata } from "next";
import "@/styles/globals.css";

export const metadata: Metadata = {
  metadataBase: new URL("https://pearlhub.lk"),
  title: "PearlHub 2.0",
  description: "Sri Lanka's most trusted luxury multi-vertical marketplace",
  keywords: [
    "Sri Lanka marketplace",
    "luxury stays Sri Lanka",
    "vehicle rentals Sri Lanka",
    "concierge booking platform",
    "tour and experience marketplace"
  ],
  alternates: {
    canonical: "/"
  },
  openGraph: {
    title: "PearlHub 2.0",
    description: "Property, stays, vehicles, events, services, tours and experiences",
    type: "website",
    url: "https://pearlhub.lk"
  },
  twitter: {
    card: "summary_large_image",
    title: "PearlHub 2.0",
    description: "Luxury multi-vertical marketplace for Sri Lanka"
  }
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
