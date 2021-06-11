-- Script to INSERT new records in tblWMARaceTimes for one event

INSERT INTO tblWMARaceTimes (
	RunnerID
	,RaceID
	,WMARunnerLevel
	,RaceTime
	,WMARaceTime
	)
SELECT tblRunners.RunnerID
	,tblRaceTimes.RaceID
	,tblWMA.WMAFactor
	,tblRaceTimes.RaceTime
	,SEC_TO_TIME(tblWMA.WMAFactor * TIME_TO_SEC(tblRaceTimes.RaceTime)) AS WMAAdjustedTime
FROM tblRunners
LEFT JOIN tblWMA ON (
		FLOOR(DATEDIFF((
					SELECT tblRaces.RaceDate
					FROM tblRaces
					WHERE tblRaces.RaceID = 125
					), RunnerDOB) / 365.25)
		) = tblWMA.WMAAge
	AND tblRunners.RunnerSex = tblWMA.WMASex
LEFT JOIN tblRaceTimes ON tblRunners.RunnerID = tblRaceTimes.RunnerID
	AND tblRaceTimes.RaceID = 125
LEFT JOIN tblRaces ON tblRaceTimes.RaceID = tblRaces.RaceID
WHERE FLOOR(DATEDIFF((
				SELECT tblRaces.RaceDate
				FROM tblRaces
				WHERE tblRaces.RaceID = 125
				), RunnerDOB) / 365.25) >= 35
	AND tblWMA.WMADistance = (
		SELECT (tblRaces.RaceDist / 1000) AS RaceDistKmToM
		FROM tblRaces
		WHERE tblRaces.RaceID = 125
		)
	AND tblRaces.RaceID = 125