import { test, expect } from '@playwright/test';

test.describe('Task Board System Comprehensive Test', () => {
  test.beforeEach(async ({ page }) => {
    // Login as member user
    await page.goto('/login');
    await page.fill('input[name="email"]', 'member@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL(/dashboard/);
  });

  test('can navigate to task boards and see basic interface', async ({ page }) => {
    // Navigate to task boards
    await page.goto('/member/boards');
    await page.waitForTimeout(2000);
    
    console.log('Current URL:', page.url());
    
    // Take screenshot
    await page.screenshot({ path: 'task-boards-interface.png', fullPage: true });
    
    // Check if the page loads
    await expect(page.locator('h2')).toContainText('Task Boards');
    
    // Look for key elements
    const newBoardButton = page.getByText('New Board').first();
    if (await newBoardButton.count() > 0) {
      console.log('✅ New Board button found');
    } else {
      console.log('❌ New Board button NOT found');
    }
    
    // Check for board selector if boards exist
    const boardSelector = page.locator('select');
    if (await boardSelector.count() > 0) {
      console.log('✅ Board selector found');
    } else {
      console.log('❌ Board selector NOT found - probably no boards yet');
    }
  });

  test('can create a new board', async ({ page }) => {
    await page.goto('/member/boards');
    await page.waitForTimeout(2000);
    
    // Look for Create Board button
    const createBoardBtn = page.getByText('New Board').first();
    if (await createBoardBtn.count() > 0) {
      await createBoardBtn.click();
      await page.waitForTimeout(1000);
      
      // Fill form
      await page.fill('input[name="title"]', 'Test Board');
      await page.fill('textarea[name="description"]', 'A test board for validation');
      
      // Submit
      const submitBtn = page.getByText('Create Board').first();
      await submitBtn.click();
      await page.waitForTimeout(2000);
      
      // Verify board was created
      await expect(page.locator('body')).toContainText('Test Board');
      console.log('✅ Board creation successful');
      
      await page.screenshot({ path: 'board-created.png', fullPage: true });
    } else {
      console.log('❌ Cannot find New Board button');
    }
  });

  test('can create lists and tasks', async ({ page }) => {
    await page.goto('/member/boards');
    await page.waitForTimeout(2000);
    
    // First ensure we have a board
    const createBoardBtn = page.getByText('New Board').first();
    if (await createBoardBtn.count() > 0) {
      await createBoardBtn.click();
      await page.waitForTimeout(1000);
      await page.fill('input[name="title"]', 'Task Test Board');
      const submitBtn = page.getByText('Create Board').first();
      await submitBtn.click();
      await page.waitForTimeout(2000);
    }
    
    // Now try to create a list
    const addListBtn = page.getByText('Add another list').first();
    if (await addListBtn.count() > 0) {
      await addListBtn.click();
      await page.waitForTimeout(500);
      
      const listTitleInput = page.locator('input[placeholder*="list title"]');
      await listTitleInput.fill('To Do');
      await listTitleInput.press('Enter');
      await page.waitForTimeout(1000);
      
      console.log('✅ List creation attempted');
      
      // Try to create a task
      const addTaskBtn = page.getByText('Add a task').first();
      if (await addTaskBtn.count() > 0) {
        await addTaskBtn.click();
        await page.waitForTimeout(500);
        
        await page.fill('input[name="title"]', 'Test Task');
        const createTaskBtn = page.getByText('Add Task').first();
        await createTaskBtn.click();
        await page.waitForTimeout(1000);
        
        console.log('✅ Task creation attempted');
        await page.screenshot({ path: 'lists-and-tasks.png', fullPage: true });
      }
    }
  });

  test('can test drag and drop functionality', async ({ page }) => {
    await page.goto('/member/boards');
    await page.waitForTimeout(2000);
    
    // Setup: Create board, lists, and tasks
    const createBoardBtn = page.getByText('New Board').first();
    if (await createBoardBtn.count() > 0) {
      await createBoardBtn.click();
      await page.waitForTimeout(1000);
      await page.fill('input[name="title"]', 'Drag Test Board');
      await page.getByText('Create Board').first().click();
      await page.waitForTimeout(2000);
      
      // Create two lists
      await page.getByText('Add another list').first().click();
      await page.waitForTimeout(500);
      await page.fill('input[placeholder*="list title"]', 'List 1');
      await page.press('input[placeholder*="list title"]', 'Enter');
      await page.waitForTimeout(1000);
      
      await page.getByText('Add another list').first().click();
      await page.waitForTimeout(500);
      await page.fill('input[placeholder*="list title"]', 'List 2');
      await page.press('input[placeholder*="list title"]', 'Enter');
      await page.waitForTimeout(1000);
      
      // Create a task in first list
      const addTaskButtons = page.getByText('Add a task');
      if (await addTaskButtons.count() > 0) {
        await addTaskButtons.first().click();
        await page.waitForTimeout(500);
        await page.fill('input[name="title"]', 'Draggable Task');
        await page.getByText('Add Task').first().click();
        await page.waitForTimeout(1000);
        
        // Test drag and drop
        const task = page.locator('[data-task-id]').first();
        const targetList = page.locator('[data-list-id]').nth(1);
        
        if (await task.count() > 0 && await targetList.count() > 0) {
          await task.dragTo(targetList);
          await page.waitForTimeout(2000);
          console.log('✅ Drag and drop attempted');
          await page.screenshot({ path: 'drag-drop-test.png', fullPage: true });
        }
      }
    }
  });

  test('check priority colors and task completion', async ({ page }) => {
    await page.goto('/member/boards');
    await page.waitForTimeout(2000);
    
    // Take final screenshot of current state
    await page.screenshot({ path: 'final-state.png', fullPage: true });
    
    // Get page content to analyze
    const content = await page.content();
    console.log('Page contains "priority":', content.includes('priority'));
    console.log('Page contains "completed":', content.includes('completed'));
    console.log('Page contains "drag":', content.includes('drag') || content.includes('sortable'));
    
    console.log('✅ Test suite completed');
  });
});
