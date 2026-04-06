import type { MetadataRoute } from "next";

export default function sitemap(): MetadataRoute.Sitemap {
  const root = "https://pearlhub.lk";
  const now = new Date();

  return [
    { url: `${root}/`, lastModified: now, changeFrequency: "daily", priority: 1 },
    { url: `${root}/listings`, lastModified: now, changeFrequency: "hourly", priority: 0.95 },
    { url: `${root}/provider`, lastModified: now, changeFrequency: "daily", priority: 0.85 },
    { url: `${root}/dashboard`, lastModified: now, changeFrequency: "daily", priority: 0.8 },
    { url: `${root}/academy`, lastModified: now, changeFrequency: "daily", priority: 0.75 },
    { url: `${root}/livestreams`, lastModified: now, changeFrequency: "hourly", priority: 0.78 },
    { url: `${root}/social`, lastModified: now, changeFrequency: "daily", priority: 0.7 },
    { url: `${root}/resale`, lastModified: now, changeFrequency: "daily", priority: 0.68 },
    { url: `${root}/voice`, lastModified: now, changeFrequency: "weekly", priority: 0.6 }
  ];
}
