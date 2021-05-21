/* Short Champ viewshortchamprunners2018*/
SELECT DISTINCT tblShortChampDivGenOverallPoints.RunnerID AS RunnerID,
tblRunners.RunnerFirstName AS RunnerFirstName,
tblRunners.RunnerSurname AS RunnerSurname,
tblShortChampDivGenOverallPoints.RunnerSex AS RunnerSex,
tblShortChampDivGenOverallPoints.RunnerDiv AS RunnerDiv,
tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints AS ShortChampDivGenOverallPoints,
tblShortChampDivGenOverallPoints.ChampionshipID AS ChampionshipID,
tblShortChampDivGenOverallPoints.ChampYear AS ChampYear
FROM ((tblShortChampDivGenOverallPoints
        JOIN tblRunners on((tblShortChampDivGenOverallPoints.RunnerID = tblRunners.RunnerID)))
       JOIN tblMembershipArchive on((tblShortChampDivGenOverallPoints.RunnerID = tblMembershipArchive.RunnerID)))
WHERE   tblShortChampDivGenOverallPoints.ChampYear = 2018
    AND tblShortChampDivGenOverallPoints.RunnerSex IN ('M','F')
    AND (tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints > 0)
    AND (tblShortChampDivGenOverallPoints.RunnerDiv=99)
ORDER BY tblShortChampDivGenOverallPoints.RunnerSex,
tblShortChampDivGenOverallPoints.ShortChampDivGenOverallPoints desc