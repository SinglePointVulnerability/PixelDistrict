/* Short Champ viewshortchamprunners */
SELECT DISTINCT tblShortChampDivGenOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblRunners.RunnerSex AS RunnerSex,
tblMembershipArchive.RunnerDiv AS RunnerDiv,
tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints AS ShortChampDivGenOverallPoints,
tblShortChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,
tblShortChampDivGenOverallPoints.ChampYear AS ChampYear
FROM tblShortChampDivGenOverallPoints
       JOIN tblRunners on tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID
      JOIN tblMembershipArchive on tblShortChampDivGenOverallPoints.RunnerID = tblMembershipArchive.RunnerID
WHERE tblShortChampDivGenOverallPoints.ChampYear > 2018
       AND tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0
       AND tblShortChampDivGenOverallPoints.RunnerSex IN ('M','F')
ORDER BY tblRunners.RunnerSex desc,tblMembershipArchive.RunnerDiv,tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints desc