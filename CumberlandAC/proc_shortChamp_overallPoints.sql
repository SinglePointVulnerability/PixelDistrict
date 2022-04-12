BEGIN
DECLARE record_exists, total_points, champ_year INT;

SET champ_year = (SELECT ChampYear FROM tblRaces WHERE RaceID = race_id);

SET record_exists = (SELECT ChampionshipID FROM tblShortChampOverall WHERE RunnerID = runner_id AND ChampionshipID = 2);

SET total_points = (SELECT SUM(ShortChampRacePoints) FROM
(SELECT ShortChampRacePoints
 FROM tblShortChampRacePoints
 WHERE RunnerID = runner_id AND RaceID IN
 (Select RaceID
  FROM tblRaces
  WHERE RaceCode IN (8,9) AND ChampYear = champ_year)
 ORDER BY ShortChampRacePoints DESC LIMIT 6) overall);
 
IF record_exists IS NOT NULL THEN UPDATE tblShortChampOverall SET ShortChampOverallPoints = total_points WHERE RunnerID = runner_id AND ChampionshipID = 2;
ELSE INSERT INTO tblShortChampOverall (RunnerID,ShortChampOverallPoints,ChampionshipID) VALUES (runner_id,total_points,2);
END IF;
END