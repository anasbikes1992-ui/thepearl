import type { Metadata } from "next";
import "@/styles/globals.css";

export const metadata: Metadata = {
  title: "PearlHub 2.0",
  description: "Sri Lanka's most trusted luxury multi-vertical marketplace",
  openGraph: {
    title: "PearlHub 2.0",
    description: "Property, stays, vehicles, events, services, tours and experiences",
    type: "website"
  }
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
