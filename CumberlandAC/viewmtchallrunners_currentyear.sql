/* NOTE: for the current year, the RunnerDiv is populated using tblRunners NOT tblMembershipArchive */
SELECT DISTINCT tblMTChallDivGenOverallPoints.RunnerID,
tblRunners.RunnerFirstName,
tblRunners.RunnerSurname,
tblMTChallDivGenOverallPoints.RunnerSex,
tblRunners.RunnerDiv,
tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints,
tblMTChallDivGenOverallPoints.ChampionshipID,
tblMTChallDivGenOverallPoints.ChampYear
FROM tblMTChallDivGenOverallPoints
    JOIN tblRunners ON tblMTChallDivGenOverallPoints.RunnerID = tblRunners.RunnerID
WHERE tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints > 0
    AND tblMTChallDivGenOverallPoints.ChampYear = 2022
ORDER BY tblMTChallDivGenOverallPoints.RunnerSex,
tblMTChallDivGenOverallPoints.MTChallDivGenOverallPoints DESC