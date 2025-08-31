import { test, expect } from '@playwright/test';

test('basic application check', async ({ page }) => {
  await page.goto('/');
  await expect(page).toHaveTitle(/Laravel/);
  console.log('✅ Application loads');
});
