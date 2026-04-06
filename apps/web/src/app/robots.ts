import type { MetadataRoute } from "next";

export default function robots(): MetadataRoute.Robots {
  const root = "https://pearlhub.lk";

  return {
    rules: [
      {
        userAgent: "*",
        allow: "/",
        disallow: ["/api/", "/dashboard"]
      }
    ],
    sitemap: `${root}/sitemap.xml`,
    host: root
  };
}
