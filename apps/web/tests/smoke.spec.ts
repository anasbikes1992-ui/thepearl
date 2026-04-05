import { test, expect } from "@playwright/test";

test("homepage renders", async ({ page }) => {
  await page.goto("/");
  await expect(page.getByText("PearlHub 2.0")).toBeVisible();
});
