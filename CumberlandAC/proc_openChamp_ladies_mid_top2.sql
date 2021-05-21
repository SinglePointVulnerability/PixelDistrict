BEGIN
DECLARE record_exists, total_points, champ_year INT;

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists = (SELECT ChampionshipID FROM tblOpenChampLadiesOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

SET total_points = (SELECT SUM(LadiesRacePoints) FROM
(SELECT tblOpenChampLadiesRacePoints.LadiesRacePoints FROM tblOpenChampLadiesRacePoints
 WHERE RunnerID=runner_id AND RaceID IN (SELECT RaceID FROM tblRaces WHERE RaceCode = 2 AND ChampYear = champ_year)
 ORDER BY LadiesRacePoints DESC LIMIT 2) overall);
 
IF record_exists IS NOT NULL THEN UPDATE tblOpenChampLadiesOverallPoints SET OpenChampCatMidLadiesOverallPoints = total_points WHERE RunnerID = runner_id AND ChampYear = champ_year;
ELSE INSERT INTO tblOpenChampLadiesOverallPoints (RunnerID, OpenChampCatMidLadiesOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, total_points, 1, champ_year);
END IF;
END