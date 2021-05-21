BEGIN
  #RunnerSex allows mixed sex split by division
  #RunnerDiv = 99 allows mixed divisions split by sex
SET @race_points = (101-rank);

  IF EXISTS (SELECT * FROM tblShortChampDivGenRacePoints WHERE RaceID = race_id AND RunnerID = runner_id AND RunnerSex = 'M' AND RunnerDiv < 99) THEN UPDATE tblShortChampDivGenRacePoints SET ShortChampDivGenRacePoints = @race_points, RunnerSex = 'M', RunnerDiv = 3 WHERE RunnerID = runner_id AND RaceID = race_id AND RunnerSex = 'M';
  ELSE INSERT INTO tblShortChampDivGenRacePoints (RaceID,ShortChampDivGenRacePoints,RunnerID,RunnerSex,RunnerDiv) VALUES (race_id,@race_points,runner_id,'M',3);
  END IF;

END