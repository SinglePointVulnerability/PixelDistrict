BEGIN
DECLARE record_exists_mf_id, record_exists_joint_id, total_points_mf, total_points_joint, champ_year, runner_div INT;
DECLARE runner_sex VARCHAR(5);

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_mf_id = (SELECT OpenChampDivGenOverallPointsID FROM tblOpenChampDivGenOverallPoints WHERE RunnerID = runner_id AND (RunnerSex = 'M' OR RunnerSex = 'F') AND ChampYear = champ_year);
/*
SET record_exists_joint_id = (SELECT OpenChampDivGenOverallPointsID FROM tblOpenChampDivGenOverallPoints WHERE RunnerID = runner_id AND RunnerSex = 'Joint' AND ChampYear = champ_year);
*/
SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID = runner_id);

SET runner_div = (SELECT RunnerDiv FROM tblRunners WHERE RunnerID = runner_id);

SET total_points_mf = (SELECT SUM(OpenChampCatLongDivGenOverallPoints+OpenChampCatMidDivGenOverallPoints+OpenChampCatSprintDivGenOverallPoints) AS OpenChampTotal FROM tblOpenChampDivGenOverallPoints WHERE RunnerID = runner_id AND (RunnerSex = 'M' OR RunnerSex = 'F') AND ChampYear = champ_year);

IF record_exists_mf_id IS NOT NULL THEN
UPDATE tblOpenChampDivGenOverallPoints SET OpenChampDivGenOverallPoints = total_points_mf, RunnerSex = runner_sex, RunnerDiv = runner_div, ChampYear = champ_year WHERE OpenChampDivGenOverallPointsID = record_exists_mf_id;
ELSE
INSERT INTO tblOpenChampDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, OpenChampDivGenOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, runner_sex, runner_div, total_points_mf, 1, champ_year);
END IF;

/*
SET total_points_joint = (SELECT SUM(OpenChampCatLongDivGenOverallPoints+OpenChampCatMidDivGenOverallPoints+OpenChampCatSprintDivGenOverallPoints) AS OpenChampTotal FROM tblOpenChampDivGenOverallPoints WHERE RunnerID = runner_id AND RunnerSex = 'Joint' AND ChampYear = champ_year);

IF record_exists_joint_id IS NOT NULL THEN
UPDATE tblOpenChampDivGenOverallPoints SET OpenChampDivGenOverallPoints = total_points_joint, RunnerSex = 'Joint', RunnerDiv = runner_div, ChampYear = champ_year WHERE OpenChampDivGenOverallPointsID = record_exists_joint_id;
ELSE
INSERT INTO tblOpenChampDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, OpenChampDivGenOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, 'Joint', runner_div, total_points_joint, 1, champ_year);
END IF;
*/
END