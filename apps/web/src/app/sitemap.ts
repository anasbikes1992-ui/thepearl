import type { MetadataRoute } from "next";

export default function sitemap(): MetadataRoute.Sitemap {
  const root = "https://pearlhub.lk";

  return [
    { url: `${root}/`, changeFrequency: "daily", priority: 1 },
    { url: `${root}/listings`, changeFrequency: "hourly", priority: 0.9 },
    { url: `${root}/provider`, changeFrequency: "daily", priority: 0.8 },
    { url: `${root}/dashboard`, changeFrequency: "daily", priority: 0.7 }
  ];
}
