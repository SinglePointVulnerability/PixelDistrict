select distinct tblOpenChampLadiesOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblMembershipArchive.RunnerDiv AS RunnerDiv,
tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints AS OpenChampLadiesOverallPoints,
tblOpenChampLadiesOverallPoints.ChampionshipID AS ChampionshipID,
tblOpenChampLadiesOverallPoints.ChampYear AS ChampYear
FROM tblOpenChampLadiesOverallPoints
       JOIN tblRunners on tblOpenChampLadiesOverallPoints.RunnerID = tblRunners.RunnerID
      JOIN tblMembershipArchive on tblOpenChampLadiesOverallPoints.RunnerID = tblMembershipArchive.RunnerID
WHERE tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints > 0
ORDER BY tblRunners.RunnerSex desc,
tblMembershipArchive.RunnerDiv,
tblOpenChampLadiesOverallPoints.OpenChampLadiesOverallPoints desc