BEGIN
DECLARE record_exists_ladies_id, total_points_ladies, champ_year INT;
DECLARE runner_sex VARCHAR(5);

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_ladies_id = (SELECT OpenChampLadiesOverallPointsID FROM tblOpenChampLadiesOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID = runner_id);

SET total_points_ladies = (SELECT SUM(OpenChampCatLongLadiesOverallPoints+OpenChampCatMidLadiesOverallPoints+OpenChampCatSprintLadiesOverallPoints) AS OpenChampLadiesTotal FROM tblOpenChampLadiesOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

IF record_exists_ladies_id IS NOT NULL THEN
UPDATE tblOpenChampLadiesOverallPoints SET OpenChampLadiesOverallPoints = total_points_ladies WHERE OpenChampLadiesOverallPointsID = record_exists_ladies_id;
ELSE
INSERT INTO tblOpenChampLadiesOverallPoints (RunnerID, OpenChampLadiesOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, total_points_ladies, 1, champ_year);
END IF;
END