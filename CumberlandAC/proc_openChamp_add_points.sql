BEGIN
IF championship_category = 1 THEN
  IF EXISTS (SELECT * FROM tblOpenChampRacePoints WHERE RaceID = race_id AND RunnerID = runner_id) THEN UPDATE tblOpenChampRacePoints SET OpenChampRacePoints = race_points WHERE RunnerID = runner_id AND RaceID = race_id;
  ELSE INSERT INTO tblOpenChampRacePoints (RaceID,OpenChampRacePoints,RunnerID) VALUES (race_id,race_points,runner_id);
  END IF;
END IF;

END