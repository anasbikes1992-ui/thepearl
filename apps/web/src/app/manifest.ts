import type { MetadataRoute } from "next";

export default function manifest(): MetadataRoute.Manifest {
  return {
    name: "PearlHub 2.0",
    short_name: "PearlHub",
    description: "Sri Lanka luxury multi-vertical marketplace",
    start_url: "/",
    display: "standalone",
    background_color: "#F8F1E3",
    theme_color: "#0A2540",
    icons: [
      {
        src: "/icon-192.png",
        sizes: "192x192",
        type: "image/png"
      }
    ]
  };
}
