# Testing & Validation Guide

## Pre-Testing Checklist

- [ ] Clear all caches: `php artisan optimize:clear`
- [ ] Run `php artisan cache:clear`
- [ ] Ensure database is populated with test data
- [ ] Check browser console for JavaScript errors
- [ ] Monitor memory usage during tests

---

## Step 1: Test Pagination

### Shared Safari Listing Page
```
URL: http://localhost/shared-safari/list
```

**Test Cases:**
- [ ] Page loads with 12 items
- [ ] Pagination buttons appear at bottom
- [ ] Click "Next" button → shows items 13-24
- [ ] Click page number 2 → shows same items
- [ ] Click "Previous" → back to page 1
- [ ] First page: "Previous" button is disabled
- [ ] Last page: "Next" button is disabled
- [ ] Current page number is highlighted

### Safari Package Listing Page
```
URL: http://localhost/safari-package/list
```

**Repeat same tests as above**

---

## Step 2: Test Filtering

### State Filter
```
Steps:
1. Select a state from dropdown
2. Results should filter to that state only
3. Active filter tag should appear at top
4. Click X on tag to remove filter
5. Results should reset
```

### Multiple Filters
```
Steps:
1. Select State: "Rajasthan"
2. Select Park: "Ranthambore"
3. Select Price: ₹5000 - ₹10000
4. Verify all filters applied
5. Use "Clear All" button
6. All filters should reset
```

---

## Step 3: Test Sorting

### Test Each Sort Option
- [ ] "All" - Default order
- [ ] "Popular" - Ordered by popularity
- [ ] "Latest" - Newest first
- [ ] "Trending" - Most trending first
- [ ] "Top Rated" - Highest rated first

**Verify:** Results reorder correctly for each option

---

## Step 4: Test Filter Removal

### Individual Filter Removal
```
1. Apply multiple filters
2. Click X on one filter tag
3. Only that filter should be removed
4. Other filters remain active
```

### Clear All Filters
```
1. Apply multiple filters
2. Click "Clear All"
3. All filters should reset
4. Page should show all results
```

---

## Step 5: Mobile Responsiveness

### On Mobile Browser (375px width)
```
Steps:
1. Load shared-safari/list page
2. Sidebar should be hidden (toggle button visible)
3. Main content should fill screen
4. Pagination buttons should stack vertically
5. Click filter toggle button
6. Sidebar should appear in modal/overlay
7. Filters should work normally
8. Close sidebar and verify main content shows
```

---

## Step 6: Memory & Performance Testing

### Memory Usage Monitoring

**Check Current Memory Usage:**
```php
// Add this to your Livewire component render method temporarily
$memory = memory_get_usage(true) / 1024 / 1024;
$peak = memory_get_peak_usage(true) / 1024 / 1024;
error_log("Memory: {$memory}MB (Peak: {$peak}MB)");
```

**Expected Results:**
- Memory usage: 20-50MB
- Peak memory: 50-100MB
- Not exceeding 512MB at any time

### Load Testing

**Simulate Multiple Users:**
```bash
# Using Apache Bench
ab -n 100 -c 10 http://localhost/shared-safari/list

# Using curl loop
for i in {1..50}; do curl http://localhost/shared-safari/list > /dev/null; done
```

**Expected Results:**
- No memory errors
- All requests complete successfully
- Response time: 0.5-2 seconds per request

---

## Step 7: Filter Persistence

### Test Filter State

```
Steps:
1. Apply filters and sort
2. Navigate to page 2
3. Filters should remain active
4. Go back to page 1
5. Filters should still be active
6. Close and reopen browser
7. Filters should NOT persist (fresh page load)
```

---

## Step 8: Edge Cases

### Empty Results
```
Steps:
1. Apply impossible filter combination
2. "Data Not Found" message should appear
3. Image should display
4. User should still see filter options to clear
```

### Single Page Results
```
Steps:
1. Filter to show < 12 results
2. Pagination should NOT appear
3. All results should display on single page
```

### Many Pages
```
Steps:
1. With 10K records and 12 per page = 833 pages
2. Load different page numbers
3. URL parameters should update
4. Results should match pagination
```

---

## Step 9: Sidebar Sidebar Filter Behavior

### Sidebar Updates
```
Steps:
1. Load page (sidebar loads)
2. States dropdown should populate
3. Parks dropdown should populate
4. Price range should show min/max values
5. All values should load quickly (< 1 second)
```

### Sidebar Caching
```
Steps:
1. Load page and note states/parks listed
2. Refresh page
3. Same values should appear immediately (from cache)
4. No additional database queries for sidebar data
```

---

## Step 10: Browser Console

### Check for JavaScript Errors
- [ ] Open DevTools (F12)
- [ ] Go to Console tab
- [ ] Should show no red error messages
- [ ] Navigate through pages
- [ ] Apply filters
- [ ] Should remain error-free

### Check Network Tab
- [ ] All requests should return 200 OK
- [ ] No 500 server errors
- [ ] No 404 not found errors
- [ ] Response times < 2 seconds

---

## Step 11: Database Query Monitoring

### Enable Query Logging
Add to `.env`:
```
DB_LOG_QUERIES=true
```

Add to `config/logging.php`:
```php
'queries' => [
    'driver' => 'single',
    'path' => storage_path('logs/queries.log'),
],
```

**Check Queries File:**
```bash
tail -f storage/logs/queries.log
```

**Expected Results:**
- [ ] Queries should be < 2ms each (simple selects)
- [ ] Join queries should be < 10ms
- [ ] No N+1 query problems
- [ ] Total queries per page load: 5-8 (not 15+)

---

## Step 12: Cache Verification

### Check Cache is Working

**Add debug code temporarily:**
```php
// In SafariesSideBar.php mount()
$startTime = microtime(true);
$states = Cache::remember('sidebar_package_state_ids', 3600, function () {
    return State::select('state_id', 'name')->pluck('name', 'state_id');
});
$time = (microtime(true) - $startTime) * 1000;
error_log("Query time: {$time}ms");
```

**Expected Results:**
- First load: 50-200ms (database query)
- Second load: < 5ms (from cache)

---

## Rollback Test

If issues occur, test rollback:

```bash
# Check git status
git status

# View recent changes
git diff

# Rollback to previous version
git checkout app/Livewire/Front/SharedSafari/Listing.php

# Clear caches
php artisan optimize:clear
```

---

## Final Validation Checklist

- [ ] No memory errors on high load
- [ ] Pagination works smoothly
- [ ] All filters function correctly
- [ ] Sort options work as expected
- [ ] Mobile responsive
- [ ] No JavaScript errors
- [ ] Performance < 1 second per page
- [ ] Database queries optimized
- [ ] Cache is working
- [ ] User can complete full workflow
- [ ] Edge cases handled properly
- [ ] Ready for production deployment

---

## Performance Baseline

Before deploying to production, establish baseline metrics:

```
Metric              | Target        | Actual
--------------------|---------------|----------
Memory per page     | < 50MB        | ___MB
Page load time      | < 1s          | ___ms
Database queries    | < 8           | ___
API response time   | < 200ms       | ___ms
Mobile load time    | < 2s          | ___ms
```

Record these values for future reference and performance tracking.

