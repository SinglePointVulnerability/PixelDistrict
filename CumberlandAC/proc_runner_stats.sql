BEGIN

IF champ_year = YEAR(CURDATE()) THEN
    SET paid_up_members = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y');

    SET paid_up_members_div1 = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1);

    SET paid_up_members_div2 = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2);

    SET paid_up_members_div3 = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3);

    SET paid_up_members_div1_men = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div1_ladies = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1 AND tblRunners.RunnerSex='F');

    SET paid_up_members_div2_men = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div2_ladies = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2 AND tblRunners.RunnerSex='F');

    SET paid_up_members_div3_men = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div3_ladies = (SELECT COUNT(RunnerID) FROM tblRunners WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3 AND tblRunners.RunnerSex='F');

    SET active_runners = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 1 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 2 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblRunners ON tblRaceTimes.RunnerID = tblRunners.RunnerID WHERE tblRunners.RunnerSubsPaid = 'Y' AND tblRunners.RunnerDiv = 3 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));
ELSE
    SET paid_up_members = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive WHERE tblMembershipArchive.MembershipYear = champ_year);

    SET paid_up_members_div1 = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1);

    SET paid_up_members_div2 = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2);

    SET paid_up_members_div3 = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3);

    SET paid_up_members_div1_men = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div1_ladies = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1 AND tblRunners.RunnerSex='F');

    SET paid_up_members_div2_men = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div2_ladies = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2 AND tblRunners.RunnerSex='F');

    SET paid_up_members_div3_men = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3 AND tblRunners.RunnerSex='M');

    SET paid_up_members_div3_ladies = (SELECT COUNT(tblMembershipArchive.RunnerID) FROM tblMembershipArchive JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3 AND tblRunners.RunnerSex='F');

    SET active_runners = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year  AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3 = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3 AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div1_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 1 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div2_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 2 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3_men = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3 AND tblRunners.RunnerSex='M' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));

    SET active_runners_div3_ladies = (SELECT COUNT(DISTINCT tblRaceTimes.RunnerID) FROM tblRaceTimes JOIN tblMembershipArchive ON tblRaceTimes.RunnerID = tblMembershipArchive.RunnerID JOIN tblRunners ON tblMembershipArchive.RunnerID = tblRunners.RunnerID WHERE tblMembershipArchive.MembershipYear = champ_year AND tblMembershipArchive.RunnerDiv = 3 AND tblRunners.RunnerSex='F' AND tblRaceTimes.RaceID IN (SELECT tblRaces.RaceID FROM tblRaces WHERE tblRaces.ChampYear = champ_year));
END IF;

   
SET inactive_runners = paid_up_members - active_runners;

SET inactive_runners_div1 = paid_up_members_div1 - active_runners_div1;

SET inactive_runners_div2 = paid_up_members_div2 - active_runners_div2;

SET inactive_runners_div3 = paid_up_members_div3 - active_runners_div3;

SET inactive_runners_div1_men = paid_up_members_div1_men - active_runners_div1_men;

SET inactive_runners_div1_ladies = paid_up_members_div1_ladies - active_runners_div1_ladies;

SET inactive_runners_div2_men = paid_up_members_div2_men - active_runners_div2_men;

SET inactive_runners_div2_ladies = paid_up_members_div2_ladies - active_runners_div2_ladies;

SET inactive_runners_div3_men = paid_up_members_div3_men - active_runners_div3_men;

SET inactive_runners_div3_ladies = paid_up_members_div3_ladies - active_runners_div3_ladies;
   
END