-- ============================================
-- Safari Meet Database Optimization Indexes
-- ============================================
-- Created for handling 10K+ records efficiently
-- Execute these queries to improve query performance

-- ============================================
-- Share Safari Indexes
-- ============================================

-- Index for status and approval filtering (most common filter combination)
ALTER TABLE `shared_safaris` ADD INDEX `idx_status_approved` (`status`, `is_approved`);

-- Index for park filtering
ALTER TABLE `shared_safaris` ADD INDEX `idx_safari_park_id` (`safari_park_id`);

-- Index for visit purpose filtering
ALTER TABLE `shared_safaris` ADD INDEX `idx_visit_purpose_id` (`visit_purpose_id`);

-- Index for stay category filtering
ALTER TABLE `shared_safaris` ADD INDEX `idx_stay_category_id` (`stay_category_id`);

-- Index for date filtering and sorting
ALTER TABLE `shared_safaris` ADD INDEX `idx_day` (`day`);

-- Index for sorting by popularity/trending
ALTER TABLE `shared_safaris` ADD INDEX `idx_popular` (`popular`);
ALTER TABLE `shared_safaris` ADD INDEX `idx_trending` (`trending`);
ALTER TABLE `shared_safaris` ADD INDEX `idx_top_rated` (`top_rated`);

-- Index for creation date sorting
ALTER TABLE `shared_safaris` ADD INDEX `idx_created_at` (`created_at`);

-- Combined index for common filter operations
ALTER TABLE `shared_safaris` ADD INDEX `idx_status_approved_day` (`status`, `is_approved`, `day`);

-- ============================================
-- Package Indexes
-- ============================================

-- Index for status and published filtering
ALTER TABLE `packages` ADD INDEX `idx_status_published` (`status`, `is_published`);

-- Index for park filtering
ALTER TABLE `packages` ADD INDEX `idx_park_id` (`park_id`);

-- Index for visit purpose filtering
ALTER TABLE `packages` ADD INDEX `idx_visit_purpose_id` (`visit_purpose_id`);

-- Index for stay category filtering
ALTER TABLE `packages` ADD INDEX `idx_stay_category_id` (`stay_category_id`);

-- Index for sorting by popularity/trending
ALTER TABLE `packages` ADD INDEX `idx_popular` (`popular`);
ALTER TABLE `packages` ADD INDEX `idx_trending` (`trending`);
ALTER TABLE `packages` ADD INDEX `idx_top_rated` (`top_rated`);

-- Index for creation date sorting
ALTER TABLE `packages` ADD INDEX `idx_created_at` (`created_at`);

-- ============================================
-- Park Indexes
-- ============================================

-- Index for state filtering (relationship query)
ALTER TABLE `parks` ADD INDEX `idx_state_id` (`state_id`);

-- Index for combined queries
ALTER TABLE `parks` ADD INDEX `idx_park_id_state_id` (`park_id`, `state_id`);

-- ============================================
-- Join Shared Safari Indexes
-- ============================================

-- Index for user joining safaris
ALTER TABLE `join_shared_safaris` ADD INDEX `idx_user_id` (`user_id`);

-- Index for finding user's joined safaris
ALTER TABLE `join_shared_safaris` ADD INDEX `idx_share_safari_id` (`share_safari_id`);

-- Combined index for queries
ALTER TABLE `join_shared_safaris` ADD INDEX `idx_user_safari` (`user_id`, `share_safari_id`);

-- ============================================
-- Park Species Indexes
-- ============================================

-- Index for species filtering
ALTER TABLE `park_species` ADD INDEX `idx_species_id` (`species_id`);

-- Index for park species listing
ALTER TABLE `park_species` ADD INDEX `idx_park_id` (`park_id`);

-- Combined index
ALTER TABLE `park_species` ADD INDEX `idx_park_species` (`park_id`, `species_id`);

-- ============================================
-- Feature Safaris Indexes (Many-to-Many)
-- ============================================

-- Index for feature filtering
ALTER TABLE `feature_safaris` ADD INDEX `idx_feature_id` (`feature_id`);

-- Index for safari features
ALTER TABLE `feature_safaris` ADD INDEX `idx_safari_id` (`safari_id`);

-- Combined index
ALTER TABLE `feature_safaris` ADD INDEX `idx_safari_feature` (`safari_id`, `feature_id`);

-- ============================================
-- Price Range Indexes (for numeric comparisons)
-- ============================================

-- Indexes to support price range queries
ALTER TABLE `shared_safaris` ADD INDEX `idx_min_price` (`min_price_pp`);
ALTER TABLE `shared_safaris` ADD INDEX `idx_max_price` (`max_price_pp`);

ALTER TABLE `packages` ADD INDEX `idx_min_price` (`min_price_pp`);
ALTER TABLE `packages` ADD INDEX `idx_max_price` (`max_price_pp`);

-- ============================================
-- Safari Count Indexes
-- ============================================

-- Indexes for safari number filtering
ALTER TABLE `shared_safaris` ADD INDEX `idx_no_of_safari` (`no_of_safari`);
ALTER TABLE `packages` ADD INDEX `idx_no_of_safari` (`no_of_safari`);

-- ============================================
-- Utility Indexes
-- ============================================

-- Index for seat availability checks
ALTER TABLE `shared_safaris` ADD INDEX `idx_is_seat_full` (`is_seat_full`);

-- Index for slug lookups (used in detail pages)
ALTER TABLE `shared_safaris` ADD INDEX `idx_slug` (`slug`);
ALTER TABLE `packages` ADD INDEX `idx_slug` (`slug`);

-- ============================================
-- Verify Index Creation (Optional)
-- Run after creating indexes to confirm they exist
-- ============================================

-- Show all indexes on shared_safaris table
SHOW INDEX FROM `shared_safaris`;

-- Show all indexes on packages table
SHOW INDEX FROM `packages`;

-- Show all indexes on parks table
SHOW INDEX FROM `parks`;

-- ============================================
-- Index Statistics (Optional)
-- After creating indexes, analyze table statistics
-- ============================================

-- Analyze table statistics for query optimization
ANALYZE TABLE `shared_safaris`;
ANALYZE TABLE `packages`;
ANALYZE TABLE `parks`;
ANALYZE TABLE `park_species`;
ANALYZE TABLE `join_shared_safaris`;
ANALYZE TABLE `feature_safaris`;

-- ============================================
-- Notes
-- ============================================
-- 1. These indexes will speed up filtering and sorting queries
-- 2. They will slightly increase storage and INSERT/UPDATE time
-- 3. For 10K+ records, the performance gain is significant
-- 4. Monitor index usage with: SHOW INDEX FROM table_name;
-- 5. To remove an index: ALTER TABLE table_name DROP INDEX index_name;
-- 6. Run ANALYZE TABLE after bulk inserts/updates for better statistics

