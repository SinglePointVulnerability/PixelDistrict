/* NOTE: for the current year, the RunnerDiv is populated using tblRunners NOT tblMembershipArchive */
select distinct tblOpenChampLadiesOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblRunners.RunnerDiv AS RunnerDiv,
tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints AS OpenChampLadiesOverallPoints,
tblOpenChampLadiesOverallPoints.ChampionshipID AS ChampionshipID,
tblOpenChampLadiesOverallPoints.ChampYear AS ChampYear
FROM tblOpenChampLadiesOverallPoints
       JOIN tblRunners on tblOpenChampLadiesOverallPoints.RunnerID = tblRunners.RunnerID
WHERE tblOpenChampLadiesOverallPoints.ChampYear = YEAR(CURDATE())
    AND tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints > 0
ORDER BY tblRunners.RunnerSex desc,
tblRunners.RunnerDiv,
tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints desc