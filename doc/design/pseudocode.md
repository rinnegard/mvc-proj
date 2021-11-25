# Checking if hand has Straight

Read User input
    if input = smallStraight
        smallStraightScore = 1 + 2 + 3 + 4 + 5
        x = 0
        for x=1 to 5
            if savedDiceArray has x
                x = x + 1
        if x == 5
            totalScore += smallStraightScore
