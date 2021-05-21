BEGIN
DECLARE record_exists_WMA_ID, total_points_WMA, champ_year INT;
DECLARE runner_sex VARCHAR(4);

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_WMA_ID = (SELECT OpenChampWMAOverallPointsID FROM tblOpenChampWMAOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID = runner_id);

SET total_points_WMA = (SELECT SUM(OpenChampCatLongWMAOverallPoints+OpenChampCatMidWMAOverallPoints+OpenChampCatSprintWMAOverallPoints) AS OpenChampWMATotal FROM tblOpenChampWMAOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

IF record_exists_WMA_ID IS NOT NULL THEN
UPDATE tblOpenChampWMAOverallPoints SET OpenChampWMAOverallPoints = total_points_WMA, RunnerSex = runner_sex WHERE OpenChampWMAOverallPointsID = record_exists_WMA_ID;
ELSE
INSERT INTO tblOpenChampWMAOverallPoints (RunnerID, RunnerSex, OpenChampWMAOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, runner_sex, total_points_WMA, 1, champ_year);
END IF;
END