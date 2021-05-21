BEGIN
DECLARE record_exists_WMA_ID, total_points, champ_year INT;

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists_WMA_ID = (SELECT OpenChampWMAOverallPointsID FROM tblOpenChampWMAOverallPoints WHERE RunnerID = runner_id AND ChampYear = champ_year);

SET total_points = (SELECT SUM(WMARacePoints) FROM
(SELECT tblOpenChampWMARacePoints.WMARacePoints FROM tblOpenChampWMARacePoints
 WHERE RunnerID=runner_id AND RaceID IN (SELECT RaceID FROM tblRaces WHERE RaceCode = 4 AND ChampYear = champ_year)
 ORDER BY WMARacePoints DESC LIMIT 2) overall);
 
IF record_exists_WMA_ID IS NOT NULL THEN UPDATE tblOpenChampWMAOverallPoints SET OpenChampCatLongWMAOverallPoints = total_points WHERE OpenChampWMAOverallPointsID = record_exists_WMA_ID;
ELSE INSERT INTO tblOpenChampWMAOverallPoints (RunnerID, OpenChampCatLongWMAOverallPoints, ChampionshipID, ChampYear) VALUES (runner_id, total_points, 1, champ_year);
END IF;
END