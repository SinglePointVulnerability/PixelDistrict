BEGIN
DECLARE race_points, record_exists_MTChall_id  INT;

SET race_points = (101-rank);

SET record_exists_MTChall_id = (SELECT MTChallDivGenRacePointsID FROM tblMTChallDivGenRacePoints WHERE RunnerID = runner_id AND RaceID = race_id);



IF record_exists_MTChall_id IS NOT NULL THEN
    UPDATE tblMTChallDivGenRacePoints SET MTChallDivGenRacePoints = race_points, RunnerSex = 'F'
    WHERE MTChallDivGenRacePointsID = record_exists_MTChall_id;
ELSE
    INSERT INTO tblMTChallDivGenRacePoints (RaceID,MTChallDivGenRacePoints,RunnerID,RunnerSex)
    VALUES (race_id,race_points,runner_id,'F');
  END IF;

END