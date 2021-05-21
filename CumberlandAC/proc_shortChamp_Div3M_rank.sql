BEGIN
SELECT
    RaceID,
    RunnerID,
    RaceTime,
    rank
FROM (
    SELECT
        *,
        IF(RaceTime = @_last_race_time, @cur_rank := @cur_rank, @cur_rank := @_sequence) AS rank,
        @_sequence := @_sequence + 1,
        @_last_race_time := RaceTime
    FROM tblRaceTimes, (SELECT @cur_rank := 1, @_sequence := 1, @_last_race_time := NULL) r
    WHERE RaceID=race_id AND RunnerID IN (SELECT RunnerID FROM tblRunners WHERE RunnerDiv=3 AND RunnerSex='M')
    ORDER BY RaceTime
) ranked
WHERE RaceID=race_id AND RunnerID IN (SELECT RunnerID FROM tblRunners WHERE RunnerDiv=3 AND RunnerSex='M')
ORDER BY RaceTime;

# https://mattmazur.com/2017/03/26/exploring-ranking-techniques-in-mysql$$
END