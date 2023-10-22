const colors = ['Amethyst', 'Banana', 'Basil', 'BeachRock', 'Beef', 'BellPepper', 'Berry', 'Blackberry', 'Blueberry', 'BlueMushroom', 'BlueRaspberry', 'Bubblegum', 'BurntToast', 'Cherry', 'Cinnamon', 'Cornflower', 'CottonCandy', 'Cranberry', 'Denim', 'Dewdrop', 'Eggplant', 'FruitSnack', 'Gold', 'Goldfish', 'GreenGrape', 'Guava', 'Gumdrop', 'Haunt', 'Holiday', 'HotChocolate', 'Icing', 'Ink', 'Iron', 'JellyBean', 'Juice', 'Kiwi', 'Latte', 'Lavender', 'Leaf', 'Lemon', 'Lime', 'Love', 'Mandarin', 'Marker', 'Marmalade', 'Mocha', 'Molasses', 'Night', 'Oatmeal', 'Olive', 'Orange', 'Papaya', 'Party', 'Pastel', 'Peach', 'Pillow', 'Pine', 'Plum', 'Potato', 'PurpleGrape', 'Rock', 'Sardine', 'Seafoam', 'Shell', 'Silver', 'Snow', 'SoftServe', 'Taffy', 'Tomato', 'Vanilla', 'Waterfall', 'Yarn', 'Retro', 'RedPanda', 'Bee', 'Sloth'];
const hair = ['Floof', 'Wave', 'Mane', 'Mop', 'Flowing'];
const tail = ['Dragon', 'Long', 'Nub', 'Poof'];
const face = ['Silly', 'Happy'];
const clothes = ['None', 'None', 'None', 'None', 'None', 'HarnessTrans', 'HarnessBrown', 'HarnessPink', 'HarnessBlue', 'BandagesChest', 'ServiceVestBeige', 'ServiceVestBlue', 'ServiceVestPink', 'ServiceVestRed'];
const hats = ['None', 'None', 'None', 'None', 'FlowerCrownPastel', 'Glasses', 'Halo'];
const affirmations = ['I am in the right place at the right time, doing the right thing.', 'Every decision I make is supported by my whole and inarguable experience.', 'I am allowed to ask for what I want and what I need.', 'I am allowed to feel good.', 'I am complete as I am, others simply support me.', 'I am growing and I am going at my own pace.', 'I am held and supported by those who love me.', 'I am open to healing.', 'I am optimistic because today is a new day.', 'I am still learning so it’s okay to make mistakes.', 'I am worthy of investing in myself.', 'I belong here, and I deserve to take up space.', 'I can be soft in my heart and firm in my boundaries.', 'I can hold two opposing feelings at once, it means I am processing.', 'I deserve self-respect and a clean space.', 'I embrace the questions in my heart and welcome the answers in their own time.', 'I have come farther than I would have ever thought possible, and I’m learning along the way.', 'I look forward to tomorrow and the opportunities that await me.', 'I strive for joy, not for perfection.', 'I welcome the wisdom that comes with growing older.', 'My body is beautiful in this moment and at its current size.', 'My life is not a race or competition.', 'My perspective is unique and important.', 'My weirdness is wonderful.', 'There is room for me at the table.', 'Today is an opportunity to grow and learn.', 'Words may shape me, but they do not make me. I am here already.', 'I am loved just for being who I am, just for existing.', 'The chance to love and be loved exists no matter where I am.', 'I am deliberate and afraid of nothing.', 'My life is about to be incredible.', 'My perspective is unique. It\'s important and it counts.', 'I\'m better than I used to be. Better than I was yesterday. But hopefully not as good as I\'ll be tomorrow.', 'I give myself permission to root for myself.', 'I will embrace the glorious mess that I am.', 'Failure is just another way to learn how to do something right.', 'I am getting better and better every day.', 'I am an unstoppable force of nature.', 'I am not pushed by my problems; I am led by my dreams.', 'I can be whatever I want to be.', 'I am not defined by my past; I am driven by my future.', 'I am constantly growing and evolving into a better person.', 'I am going to forgive myself and free myself. I deserve to forgive and be forgiven.', 'I\'ve made it through hard times before, and I\'ve come out stronger and better because of them. I\'m going to make it through this', 'I belong in this world; there are people that care about me and my worth.', 'My past may be ugly, but I am still beautiful.', 'I have made mistakes, but I will not let them define me.', 'I don\'t compare myself to others. The only person I compare myself to is the person I was yesterday. And as long as the person I am today is even the tiniest bit better than the person I was yesterday—I’m meeting my own definition of success.', 'I finish what matters and let go of what does not.', 'My life has meaning. What I do has meaning. My actions are meaningful and inspiring.', 'What I have done today was the best I was able to do today. And for that, I am thankful.', 'Happiness is a choice, and today I choose to be happy.', 'I have done difficult things in the past, and I can do them again.', 'I am allowed to feel upset, angry, and sad sometimes—that’s part of being human.', 'My personal boundaries are important and I’m allowed to express my needs to others.', 'I am allowed to take up space, to have desires, and to have a voice', 'All this hard work I am putting into achieving my goals will pay off.', 'Growth is sometimes bumpy and isn’t always linear, but I will stay the course.', 'In my uniqueness, I find strength. I am enough.', 'Every day, I learn. Every day, I grow.', 'Breathe. Trust. Live.', 'Focus on what I can control; release the rest.', 'I am not what happened to me. I am what I choose to become.', 'People will forget what I said, people will forget what I did, but people will never forget how I made them feel.', 'Every day, in my own way, I am becoming more successful.', 'I belong here. ', 'I add value to people\'s lives.', 'I am worthy of love and belonging.', 'My measure of success is my own. I don’t need to compare myself to others.', 'I\'m empowered to choose what’s best for me.', 'I accept and express my emotions with an open heart.', 'I am strong, resilient, and not too proud to ask for help.', 'I\'m worthy, loved, and enough.', 'I accept myself for who I am, including my strengths and flaws.', 'Practice makes progress.', 'I can learn anything I put my mind to.', 'It\'s okay to ask for help when I need it.', 'Life is tough, but so am I.', 'I don\'t always know what others are going through, so I will be kind.', 'I don’t need to be perfect. I’m only human.', 'My past does not define my future.', 'I can face my fears one step at a time.', 'I trust myself to take the next best step.', 'Courage is not the absence of fear. Courage is doing it despite my fear.', 'I’m excited about what\'s to come.', 'Today is full of opportunities.', 'I will make the most of today.', 'I did my best today.', 'I\'m proud of what I accomplished today.', 'My to-do list will be there in the morning; tonight, I rest.', 'I forgive myself for what did not go well.', 'I strive to do my best.', 'The more I learn, the more I can accomplish.', 'Learning is a journey and an adventure.', 'It\'s okay not to know everything—there’s always something to learn.', 'Failure is not fatal, and success is not final.', 'My body is worthy of kindness and care.', 'I\'m worthy of self-care daily.', 'It is okay to feel fragile, sensitive, alone, and sad. These feelings are part of being a human being.', 'I am peaceful. I am calm. I am resilient in the midst of change.', 'I do my best daily and let the future take care of itself.', 'I have gotten over every bad day so far. I will get through this one.', 'I focus on what\'s before me, one step at a time.', 'I accept both the ups and downs as valuable parts of my life.', 'I focus on being the healthiest version of myself at this moment.', 'I am investing in my health because I know I am worth it.', 'I listen to my body. My body knows what it needs.', 'My creativity knows no bounds.', 'I trust my creative instincts and follow my intuition.', 'My creativity grows with each day and each experience.', 'My creativity is a gift that I share with the world.', 'I am a winner, both in spirit and in action.', 'I allow myself to feel my grief and heal at my own pace.', 'My pain is real, but so is my resilience.', 'It\'s okay to seek help and share my feelings.', 'I belong, I am worthy, and I deserve lovely days.', 'I may be a mess, but I\'m doing my best.', 'I am absolutely "good enough" today.', 'I\'s okay to be unsure. It\'s okay to make mistakes. Every day that I try matters.', 'I will be on my own side today', 'Things will keep changing, and everyday I\'m trying, I continue to level up.', 'It\'s good that I exist.', 'I don\'t need to know how to fix everything today. Just figuring out my next step is enough.', 'It\'s okay to focus on getting through today', 'Even when I am feeling awful, I deserve nice things.', 'I am worthy of kindness and care.', 'My life is not impossible; it\'s just a difficult moment.', 'I have an amazing record of surviving difficult things.', 'I am not a burden; I am a person with needs, and that\'s completely normal.', 'These difficult days won\'t consume my whole existence. I have a lot of good life left to live.', 'I have survived 100% of my life. I can handle whatever happens.', 'Difficult days always end. I can do this.', 'I can get myself through this.', 'I am absolutely worth caring for.', 'It\'s enough to just get myself through today.', 'I don\'t need to be perfect. Messy, weird me is enough.', 'I\'m still a good "me", even when I\'m not feeling like myself.', 'A string of bad days does not equal a bad life; things can change.', 'I don\'t need to qualify my existence. I am allowed to take up space.', 'I\'m doing what I can, and that is enough.', 'I don\'t need to try to fix everything today, I can just change one thing and see how that goes.', 'My needs make sense. My limits make sense.', 'I deserve a place in this world just as I am.', 'I can take today on one small thing at a time.', 'It\'s okay to not please everyone.', 'Times are touch, but you are, too.', 'i\'m not being lazy. I\'m overwhelmed and recharging.', 'Small steps still count.', 'I matter and I always will.', 'It\'s truly impressive how far I\'ve come.', 'Bad days do not erase my progress.', 'I am good enough, I always have been.', 'I deserve recharge time.', 'This feeling will pass. I\'m not stuck here forever.', 'I may not know what the future holds, but I can handle today.', 'I\'ve survived a ton of bad days; I got this.', 'The amount of recharge time I need is entirely reasonable.', 'I am far more resilient and capable than my anxiety gives me credit for.', 'I don\'t need to be perfect to be lovable.', 'My future is worth seeing.', 'You don\'t need to solve all your problems today; it\'s enough to just make it through.', 'I will not shame myself for difficult days.', 'When it\'s hard to find kindness, I will make it myself.', 'Healing takes time, and that\'s okay.', 'My efforts will pay off in time.', 'Your body is doing it\'s best and deserves kindness today.', 'I can be grateful and depressed at the same time. I am not a bad person for struggling to find joy in things right now.'];

function snoozeling() {
    this.mainColor = chooseColor();
    this.hairType = chooseHairType();
    this.tailType = chooseTailType();
    this.nosecolor = chooseColor();
    this.eyeColor = chooseColor();
    this.faceShape = chooseFaceType();
    this.bellyMarking = flipCoin();
    this.spotsMarking = flipCoin();
    this.clothesBottom = chooseClothesBottom();
    this.clothesTop = chooseClothesTop();
    let randomNum = randomNumber(2);
    if (this.mainColor === 'Retro' || this.mainColor === 'RedPanda') {
        if (randomNum === 0) {
            this.hairColor = this.mainColor;
        } else {
            this.hairColor = chooseColor();
        }
    } else {
        this.hairColor = chooseColor();
    }
        randomNum = randomNumber(2);
        if (randomNum === 0 && this.mainColor != 'RedPanda') {
            this.tailColor = this.mainColor;
        } else {
            this.tailColor = this.hairColor;
        }
    randomNum = randomNumber(10);
    if (randomNum === 0) {
        this.angel = true;
    }
    randomNum = randomNumber(4);
    if (randomNum === 0) {
        this.wings = true;
    }


}

function randomNumber(num) {
    var randomNum = Math.floor(Math.random() * num);
    return randomNum;
}

function flipCoin() {
    var randomNum = Math.floor(Math.random() * 2);
    if (randomNum === 0) {
        return false;
    } else {
        return true;
    }
}

function chooseColor() {
    var randomNum = Math.floor(Math.random() * colors.length);
    return colors[randomNum];
}

function chooseClothesBottom() {
    var randomNum = Math.floor(Math.random() * clothes.length);
    return clothes[randomNum];
}

function chooseClothesTop() {
    var randomNum = Math.floor(Math.random() * hats.length);
    return hats[randomNum];
}

function chooseHairType() {
    var randomNum = Math.floor(Math.random() * hair.length);
    return hair[randomNum];
}

function chooseTailType() {
    var randomNum = Math.floor(Math.random() * tail.length);
    return tail[randomNum];
}

function chooseFaceType() {
    var randomNum = Math.floor(Math.random() * face.length);
    return face[randomNum];
}

function setOutfit(clothes, type, color) {
    if (clothes !== 'None') {
        const link = 'Layers/' + type + "/" + clothes + '.png';
        document.getElementById(type).src = link;
    }
    /* if else () {
           const link = 'Layers/' + type + '/' + clothes + '.png'
           document.getElementById(type).src = link;
           setMainColorPic('Body', '/Layers/AltBodies/Front/' + color + '.png');
           setMainColorPic('MainLines', 'Layers/AltLines/Front/' + color + '.png');
       } if else () {
           const link = 'Layers/' + type + '/' + clothes + '.png'
           document.getElementById(type).src = link;
           setMainColorPic('Body', '/Layers/AltBodies/Back/' + color + '.png');
           setMainColorPic('MainLines', 'Layers/AltLines/Back/' + color + '.png');
       } if else () {
           const link = 'Layers/' + type + '/' + clothes + '.png'
           document.getElementById(type).src = link;
           setMainColorPic('Body', '/Layers/AltBodies/Both/' + color + '.png');
           setMainColorPic('MainLines', 'Layers/AltLines/Both/' + color + '.png');
       } */
    else {
        document.getElementById('ClothesBottom').src = "";
    }
}

function setMainColorPic(type, file, mainColor) {
    const link = file + mainColor + ".png";
    document.getElementById(type).src = link;
}

function setNewColorPic(type, file) {
    const randomColor = chooseColor();
    const link = file + randomColor + ".png";
    document.getElementById(type).src = link;
}

function setMarkings(color, type) {
    roll = randomNumber();
    if (roll < 50) {
        setMainColorPic(type, 'Layers/Markings/' + type + "/", color);
    } else {
        document.getElementById(type).src = "";
    }
}

function snoozelingGenerate(number) {
    var snoozelingOne = new snoozeling();
    setMainColorPic('Primary' + number, 'Layers/Primary/', snoozelingOne.mainColor);
    setMainColorPic('MainLines' + number, 'Layers/MainLines/', snoozelingOne.mainColor);
    /* setMainColorPic('FaceMain', 'Layers/Faces/Tongue/', color); */
    setMainColorPic('Nose' + number, 'Layers/Noses/', snoozelingOne.nosecolor);
    const hairLink = 'Layers/Hair/' + snoozelingOne.hairType + '/';
    if (snoozelingOne.hairType === 'Floof') {
        setMainColorPic('Hair' + number, hairLink, snoozelingOne.mainColor);
    } else {
        setMainColorPic('Hair' + number, hairLink, snoozelingOne.hairColor);
    }
    document.getElementById('SecondTail' + number).src = "";
    if (snoozelingOne.tailType === 'Dragon') {
        setMainColorPic('Tail' + number, 'Layers/Tail/Dragon/', snoozelingOne.mainColor);
        setMainColorPic('SecondTail' + number, 'Layers/Tail/Dragon/End/', snoozelingOne.hairColor);
    } else if (snoozelingOne.tailType === 'Nub') {
        setMainColorPic('Tail' + number, 'Layers/Tail/Nub/', snoozelingOne.mainColor);
    } else {
        const tailLink = 'Layers/Tail/' + snoozelingOne.tailType + '/';
        setMainColorPic('Tail' + number, tailLink, snoozelingOne.tailColor);
    }
    if (snoozelingOne.bellyMarking) {
        setMainColorPic('Belly' + number, 'Layers/Markings/Belly/', snoozelingOne.mainColor);
    } else {
        document.getElementById('Belly' + number).src = "";
    }
    if (snoozelingOne.spotsMarking) {
        setMainColorPic('Spots' + number, 'Layers/Markings/Spots/', snoozelingOne.mainColor);
    } else {
        document.getElementById('Spots' + number).src = "";
    }
    if (snoozelingOne.faceShape === 'Silly') {
        setMainColorPic('Face' + number, 'Layers/Faces/Silly/', snoozelingOne.mainColor);
        document.getElementById('Eyes' + number).src = "";
        document.getElementById('mood').innerHTML = '<strong>Mood:</strong> Silly';
    } else {
        const faceString = '<strong>Mood:</strong> ' + snoozelingOne.faceShape;
        setMainColorPic('Face' + number, 'Layers/Faces/' + snoozelingOne.faceShape + '/Lines/', snoozelingOne.mainColor);
        setMainColorPic('Eyes' + number, 'Layers/Faces/' + snoozelingOne.faceShape + '/Eyes/', snoozelingOne.eyeColor);
        document.getElementById('mood').innerHTML = faceString;
    }
    if (snoozelingOne.angel === true) {
        document.getElementById('TopWing' + number).src = 'Layers/AngelWingTop.png';
        document.getElementById('BottomWing' + number).src = 'Layers/AngelWingBottom.png';
    } else if (snoozelingOne.wings === true) {
        setMainColorPic('TopWing' + number, 'Layers/Wings/Pegasus/Top/', snoozelingOne.mainColor);
        setMainColorPic('BottomWing' + number, 'Layers/Wings/Pegasus/Bottom/', snoozelingOne.mainColor);
    } else {
        document.getElementById('TopWing' + number).src = "";
        document.getElementById('BottomWing' + number).src = "";
    }
    document.getElementById('Transparent' + number).src = "Layers/transparentSquare.png";
    /*  
        setOutfit(bottom, 'ClothesBottom', color);
        setOutfit(hat, 'ClothesTop', color);

        roll = randomNumber();
         if (roll < 50) {
             document.getElementById('Whiskers').src = 'Layers/Whiskers.png';
         } */
}

function runCode() {
    snoozelingGenerate('one');
}

function getDate() {
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth();
    const year = date.getYear() + 1900;
    const text = '~ ' + months[month] + ' ' + day + ', ' + year;
    document.getElementById('date').innerHTML = text;
}

function getAffirmation() {
    const randomNum = Math.floor(Math.random() * affirmations.length);
    const affirmation = affirmations[randomNum];
    document.getElementById('affirmation').innerHTML = affirmation;
}

getDate();
getAffirmation();

/*
const users = ['Squirrel', 'Finn', 'Slothie'];
console.log(users[users.length-1]);*/
