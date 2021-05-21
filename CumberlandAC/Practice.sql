BEGIN
DECLARE record_exists_mf_id, record_exists_joint_id, total_points_mf, total_points_joint, champ_year, runner_div INT;
DECLARE runner_sex VARCHAR(4);

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_mf_id = (SELECT ShortChampDivGenOverallPointsID FROM tblShortChampDivGenOverallPoints WHERE RunnerID = runner_id AND (RunnerSex = 'M' OR RunnerSex = 'F') AND ChampionshipID = 2);

SET record_exists_joint_id = (SELECT ShortChampDivGenOverallPointsID FROM tblShortChampDivGenOverallPoints WHERE RunnerID = runner_id AND RunnerSex = 'Joint' AND ChampionshipID = 2);

SET runner_sex = (SELECT RunnerSex FROM tblRunners WHERE RunnerID = runner_id);

SET runner_div = (SELECT RunnerDiv FROM tblRunners WHERE RunnerID = runner_id);

SET total_points_mf = (SELECT SUM(ShortChampDivGenRacePoints) FROM
(SELECT ShortChampDivGenRacePoints
 FROM tblShortChampDivGenRacePoints
 WHERE RunnerID = runner_id AND (RunnerSex = 'M' OR RunnerSex = 'F') AND RaceID IN
 (Select RaceID
  FROM tblRaces
  WHERE RaceCode IN (1,9) AND ChampYear = champ_year)
 ORDER BY ShortChampDivGenRacePoints DESC LIMIT 6) overall);

IF record_exists_mf_id IS NOT NULL THEN
UPDATE tblShortChampDivGenOverallPoints SET ShortChampDivGenOverallPoints = total_points_mf, RunnerSex = runner_sex, RunnerDiv = runner_div WHERE ShortChampDivGenOverallPointsID = record_exists_mf_id;
ELSE
INSERT INTO tblShortChampDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, ShortChampDivGenOverallPoints, ChampionshipID) VALUES (runner_id, runner_sex, runner_div, total_points_mf, 2);
END IF;


SET total_points_joint = (SELECT SUM(ShortChampDivGenRacePoints) FROM
(SELECT ShortChampDivGenRacePoints
 FROM tblShortChampDivGenRacePoints
 WHERE RunnerID = runner_id AND RunnerSex = 'Joint' AND RaceID IN
 (Select RaceID
  FROM tblRaces
  WHERE RaceCode IN (1,9) AND ChampYear = champ_year)
 ORDER BY ShortChampDivGenRacePoints DESC LIMIT 6) overall2); 

IF record_exists_joint_id IS NOT NULL THEN
UPDATE tblShortChampDivGenOverallPoints SET ShortChampDivGenOverallPoints = total_points_joint, RunnerSex = 'Joint', RunnerDiv = runner_div WHERE ShortChampDivGenOverallPointsID = record_exists_joint_id;
ELSE
INSERT INTO tblShortChampDivGenOverallPoints (RunnerID, RunnerSex, RunnerDiv, ShortChampDivGenOverallPoints, ChampionshipID) VALUES (runner_id, 'Joint', runner_div, total_points_joint, 2);
END IF;
END