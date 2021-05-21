BEGIN

SELECT
    RaceID,
    RunnerID,
    WMARaceTime,
    rank
FROM (
    SELECT
        *,
        IF(WMARaceTime = @_last_WMA_race_time, @cur_rank := @cur_rank, @cur_rank := @_sequence) AS rank,
        @_sequence := @_sequence + 1,
        @_last_WMA_race_time := WMARaceTime
    FROM tblWMARaceTimes, (SELECT @cur_rank := 1, @_sequence := 1, @_last_WMA_race_time := NULL) r
    WHERE RaceID=race_id AND RunnerID IN (SELECT RunnerID FROM tblRunners WHERE RunnerSex='M')
    ORDER BY WMARaceTime
) ranked
WHERE RaceID=race_id AND RunnerID IN (SELECT RunnerID FROM tblRunners WHERE RunnerSex='M')
ORDER BY WMARaceTime;

# https://mattmazur.com/2017/03/26/exploring-ranking-techniques-in-mysql

END