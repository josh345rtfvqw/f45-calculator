-- F45 Playoffs Score Calculator — leaderboard table.
-- Only needed if moving to a fresh database. Run once, then delete this file.

CREATE TABLE IF NOT EXISTS scores (
  id           BIGINT       NOT NULL,
  score_one    DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_two    DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_three  DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_four   DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_five   DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_six    DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_seven  DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_eight  DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_nine   DECIMAL(8,4) NOT NULL DEFAULT 0,
  score_ten    DECIMAL(8,4) NOT NULL DEFAULT 0,
  total_score  DECIMAL(8,4) NOT NULL DEFAULT 0,
  created_at   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_total_score (total_score)
);
