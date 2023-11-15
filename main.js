/* //Create Moods
const moodArray = [
                    ['Afraid', 'Worried', true],
                    ['Anxious', 'Worried', true],
                    ['Calm', 'Happy', true],
                    ['Happy', 'Happy', true],
                    ['Hurt', 'Worried', true],
                    ['Playful', 'Silly', false],
                    ['Silly', 'Silly', false],
                    ['Overwhelmed', 'Worried', true],
                    ['Worried', 'Worried', true]
                ]; 

function breedSnoozeling(one, two, id) {
    let tempMainColor = {};
    let tempEyeColor = {};
    let tempHairColor = {};
    let tempTailColor = {};
    let tempNoseColor = {};
    let tempHairType = "";
    let tempTailType = "";
    let tempBellyMarking = false;
    let tempSpotsMarking = false;
    let tempWings = false;
    let tempMood = findMoodByName('Happy');


    let tempColorArray = [];
    let momColorArray = [];
    let dadColorArray = [];
    let possibleColors = [];
    let cleanColors = [];
    let specialColors = [];
    let normalColors = [];


    //Main Color Calculations
    for (let i = 0; i < one.mainColor.colorCategories.length; i++) {
        tempColorArray.push(one.mainColor.colorCategories[i]);
        momColorArray.push(one.mainColor.colorCategories[i]);
    }
    for (let i = 0; i < two.mainColor.colorCategories.length; i++) {
        tempColorArray.push(two.mainColor.colorCategories[i]);
        dadColorArray.push(two.mainColor.colorCategories[i]);
    }
    for (let i = 0; i < tempColorArray.length; i++) {
        if (tempColorArray[i] === 'Green') {
            possibleColors.push(...returnColorsByCategory('Green'));
            possibleColors.push(...returnColorsByCategory('Yellow'));
            possibleColors.push(...returnColorsByCategory('Blue'));
        }
        if (tempColorArray[i] === 'Purple') {
            possibleColors.push(...returnColorsByCategory('Purple'));
            possibleColors.push(...returnColorsByCategory('red'));
            possibleColors.push(...returnColorsByCategory('Blue'));
        }
        if (tempColorArray[i] === 'Orange') {
            possibleColors.push(...returnColorsByCategory('Orange'));
            possibleColors.push(...returnColorsByCategory('Yellow'));
            possibleColors.push(...returnColorsByCategory('Red'));
        }
        if (tempColorArray[i] === 'Pink') {
            possibleColors.push(...returnColorsByCategory('Pink'));
            possibleColors.push(...returnColorsByCategory('White'));
            possibleColors.push(...returnColorsByCategory('Red'));
        }
        possibleColors.push(...returnColorsByCategory(tempColorArray[i]));
    }
    cleanColors = removeDuplicates(possibleColors);
    for (let i = 0; i < cleanColors.length; i++) {
        if (cleanColors[i].colorRarity !== 'Rare') {
            normalColors.push(cleanColors[i]);
        }
    }
    if (one.mainColor.colorRarity === 'Rare') {
        specialColors.push(one.mainColor);
    }
    if (two.mainColor.colorRarity === 'Rare') {
        specialColors.push(two.mainColor);
    }
    if ((momColorArray.includes('Black') && dadColorArray.includes('EyeBurner')) || (dadColorArray.includes('Black') && momColorArray.includes('EyeBurner'))) {
        specialColors.push(findColorByName('Retro'));
    }
    if ((momColorArray.includes('Red') && dadColorArray.includes('Black')) || (momColorArray.includes('Red') && dadColorArray.includes('White')) || (dadColorArray.includes('Red') && momColorArray.includes('Black')) || (dadColorArray.includes('Red') && momColorArray.includes('White'))) {
        specialColors.push(findColorByName('RedPanda'));
    }
    if ((momColorArray.includes('Yellow') && dadColorArray.includes('Black')) || (momColorArray.includes('Yellow') && dadColorArray.includes('Brown')) || (dadColorArray.includes('Yellow') && momColorArray.includes('Black')) || (dadColorArray.includes('Yellow') && momColorArray.includes('Brown'))) {
        specialColors.push(findColorByName('Bee'));
    }
    if ((momColorArray.includes('Grey') && dadColorArray.includes('Black')) || (momColorArray.includes('Grey') && dadColorArray.includes('White')) || (dadColorArray.includes('Grey') && momColorArray.includes('Black')) || (dadColorArray.includes('Grey') && momColorArray.includes('White'))) {
        specialColors.push(findColorByName('Raccoon'));
    }
    if ((momColorArray.includes('Brown') && dadColorArray.includes('Green')) || (dadColorArray.includes('Brown') && momColorArray.includes('Green'))) {
        specialColors.push(findColorByName('Sloth'));
    }
    if (specialColors.length > 0) {
        const randomChance = randomNumber(4);
        if (randomChance === 0) {
            const cleanSpecialColors = removeDuplicates(specialColors);
            const selectRare = Math.floor(Math.random() * cleanSpecialColors.length);
            tempMainColor = cleanSpecialColors[selectRare];
        } else {
            const randomNum = randomNumber(normalColors.length);
            tempMainColor = normalColors[randomNum];
        }
    } else {
        const randomNum = randomNumber(normalColors.length);
        tempMainColor = normalColors[randomNum];
    }

    //Eye Calculations
    let tempEyeArray = [];
    let possibleEyes = [];
    let cleanEyes = [];
    let normalEyes = [];
    for (let i = 0; i < one.eyeColor.colorCategories.length; i++) {
        tempEyeArray.push(one.eyeColor.colorCategories[i]);
    }
    for (let i = 0; i < two.eyeColor.colorCategories.length; i++) {
        tempEyeArray.push(two.eyeColor.colorCategories[i]);
    }
    for (let i = 0; i < tempEyeArray.length; i++) {
        if (tempEyeArray[i] === 'Green') {
            possibleEyes.push(...returnColorsByCategory('Green'));
            possibleEyes.push(...returnColorsByCategory('Yellow'));
            possibleEyes.push(...returnColorsByCategory('Blue'));
        }
        if (tempEyeArray[i] === 'Purple') {
            possibleEyes.push(...returnColorsByCategory('Purple'));
            possibleEyes.push(...returnColorsByCategory('red'));
            possibleEyes.push(...returnColorsByCategory('Blue'));
        }
        if (tempEyeArray[i] === 'Orange') {
            possibleEyes.push(...returnColorsByCategory('Orange'));
            possibleEyes.push(...returnColorsByCategory('Yellow'));
            possibleEyes.push(...returnColorsByCategory('Red'));
        }
        if (tempEyeArray[i] === 'Pink') {
            possibleEyes.push(...returnColorsByCategory('Pink'));
            possibleEyes.push(...returnColorsByCategory('White'));
            possibleEyes.push(...returnColorsByCategory('Red'));
        }
        possibleEyes.push(...returnColorsByCategory(tempEyeArray[i]));
    }
    possibleColors.push(one.eyeColor);
    possibleColors.push(two.eyeColor);
    cleanEyes = removeDuplicates(possibleColors);
    for (let i = 0; i < cleanEyes.length; i++) {
        if (cleanEyes[i].colorRarity !== 'Rare') {
            normalEyes.push(cleanEyes[i]);
        }
    }
    if (tempMainColor.colorRarity === 'Rare') {
        const chance = flipCoin();
        if (chance === true) {
            tempEyeColor = tempMainColor;
        } else {
            const randomNum = randomNumber(normalEyes.length);
            tempEyeColor = normalEyes[randomNum];
        }
    } else {
        const randomNum = randomNumber(normalEyes.length);
        tempEyeColor = normalEyes[randomNum];
    }

    //Hair Calculations
    let tempHairArray = [];
    let possibleHair = [];
    let cleanHair = [];
    let normalHair = [];
    for (let i = 0; i < one.hairColor.colorCategories.length; i++) {
        tempHairArray.push(one.hairColor.colorCategories[i]);
    }
    for (let i = 0; i < two.hairColor.colorCategories.length; i++) {
        tempHairArray.push(two.hairColor.colorCategories[i]);
    }
    for (let i = 0; i < tempHairArray.length; i++) {
        if (tempHairArray[i] === 'Green') {
            possibleHair.push(...returnColorsByCategory('Green'));
            possibleHair.push(...returnColorsByCategory('Yellow'));
            possibleHair.push(...returnColorsByCategory('Blue'));
        }
        if (tempHairArray[i] === 'Purple') {
            possibleHair.push(...returnColorsByCategory('Purple'));
            possibleHair.push(...returnColorsByCategory('red'));
            possibleHair.push(...returnColorsByCategory('Blue'));
        }
        if (tempHairArray[i] === 'Orange') {
            possibleHair.push(...returnColorsByCategory('Orange'));
            possibleHair.push(...returnColorsByCategory('Yellow'));
            possibleHair.push(...returnColorsByCategory('Red'));
        }
        if (tempHairArray[i] === 'Pink') {
            possibleHair.push(...returnColorsByCategory('Pink'));
            possibleHair.push(...returnColorsByCategory('White'));
            possibleHair.push(...returnColorsByCategory('Red'));
        }
        possibleHair.push(...returnColorsByCategory(tempHairArray[i]));
    }
    cleanHair = removeDuplicates(possibleHair);
    for (let i = 0; i < cleanHair.length; i++) {
        if (cleanHair[i].colorRarity !== 'Rare') {
            normalHair.push(cleanHair[i]);
        }
    }
    normalHair.push(one.hairColor);
    normalHair.push(two.hairColor);
    console.log(normalHair);
    if (tempMainColor.colorRarity === 'Rare') {
        const chance = flipCoin();
        if (chance === true) {
            tempHairColor = tempMainColor;
        } else {
            const randomNum = randomNumber(normalHair.length);
            tempHairColor = normalHair[randomNum];
        }
    } else {
        const randomNum = randomNumber(normalHair.length);
        tempHairColor = normalHair[randomNum];
    }

    //Tail Calculations
    const hairChance = flipCoin();
    if (hairChance === true) {
        tempTailColor = tempHairColor;
    } else {
        tempTailColor = tempMainColor;
    }

    //Nose Calculations
    let tempNoseArray = [];
    let possibleNoses = [];
    let cleanNoses = [];
    for (let i = 0; i < one.noseColor.colorCategories.length; i++) {
        tempNoseArray.push(one.noseColor.colorCategories[i]);
    }
    for (let i = 0; i < two.noseColor.colorCategories.length; i++) {
        tempNoseArray.push(two.noseColor.colorCategories[i]);
    }
    for (let i = 0; i < tempNoseArray.length; i++) {
        if (tempNoseArray[i] === 'Green') {
            possibleNoses.push(...returnColorsByCategory('Green'));
            possibleNoses.push(...returnColorsByCategory('Yellow'));
            possibleNoses.push(...returnColorsByCategory('Blue'));
        }
        if (tempNoseArray[i] === 'Purple') {
            possibleNoses.push(...returnColorsByCategory('Purple'));
            possibleNoses.push(...returnColorsByCategory('red'));
            possibleNoses.push(...returnColorsByCategory('Blue'));
        }
        if (tempNoseArray[i] === 'Orange') {
            possibleNoses.push(...returnColorsByCategory('Orange'));
            possibleNoses.push(...returnColorsByCategory('Yellow'));
            possibleNoses.push(...returnColorsByCategory('Red'));
        }
        if (tempNoseArray[i] === 'Pink') {
            possibleNoses.push(...returnColorsByCategory('Pink'));
            possibleNoses.push(...returnColorsByCategory('White'));
            possibleNoses.push(...returnColorsByCategory('Red'));
        }
        possibleNoses.push(...returnColorsByCategory(tempNoseArray[i]));
    }
    possibleNoses.push(one.hairColor);
    possibleNoses.push(two.hairColor);
    cleanNoses = removeDuplicates(possibleNoses);
    if (tempMainColor.colorRarity === 'Rare') {
        const chance = flipCoin();
        if (chance === true) {
            tempNoseColor = tempMainColor;
        } else {
            const randomNum = randomNumber(cleanNoses.length);
            tempNoseColor = cleanNoses[randomNum];
        }
    } else {
        const randomNum = randomNumber(cleanNoses.length);
        tempNoseColor = cleanNoses[randomNum];
    }

    //Tailtype Selection
    let tailTypeChance = flipCoin();
    if (tailTypeChance === true) {
        tempTailType = one.tailType;
    } else {
        tempTailType = two.tailType;
    }

    //Hair Style Selection
    tempHairType = chooseFromArrayRandom(hairTypes);

    //Marking & Wing Calculations
    if (one.wings === true || two.wings === true) {
        if (one.wings === true && two.wings === true) {
            const randomNum = randomNumber(4);
            if (randomNum > 0) {
                tempWings = true;
            }
        } else {
            const chance = flipCoin();
            if (chance === true) {
                tempWings = true;
            }
        }
    }
    if (one.bellyMarking === true || two.bellyMarking === true) {
        if (one.bellyMarking === true && two.bellyMarking === true) {
            const randomNum = randomNumber(4);
            if (randomNum > 0) {
                tempBellyMarking = true;
            }
        } else {
            const chance = flipCoin();
            if (chance === true) {
                tempBellyMarking = true;
            }
        }
    }
    if (one.spotsMarking === true || two.spotsMarking === true) {
        if (one.spotsMarking === true && two.spotsMarking === true) {
            const randomNum = randomNumber(4);
            if (randomNum > 0) {
                tempSpotsMarking = true;
            }
        } else {
            const chance = flipCoin();
            if (chance === true) {
                tempSpotsMarking = true;
            }
        }
    }

    //Make New Snoozeling
    const babySnooze = new Snoozeling(id, tempMainColor, tempEyeColor, tempHairColor, tempTailColor, tempNoseColor, tempHairType, tempTailType, tempBellyMarking, tempSpotsMarking, tempWings, tempMood);
    return babySnooze;
} */

//Mood Left Bar Set
function setMoodLeft(snoozeling) {
    const mood = snoozeling.mood.moodName;
    const fullMood = '<strong>Mood:</strong> ' + mood;
    document.getElementById('mood').innerHTML = fullMood;
}

function setMoodSelect(mood, snoozeling) {
    const fullMood = '<strong>Mood:</strong> ' + mood.moodName;
    document.getElementById('mood').innerHTML = fullMood;
    if (mood.colors === false) {
        document.getElementById('Faceone').src = 'Layers/Faces/' + mood.fileName + '/BlueRaspberry.png';
        document.getElementById('Eyesone').src = '';
    } else {
        document.getElementById('Faceone').src = 'Layers/Faces/' + mood.fileName + '/Lines/BlueRaspberry.png';
        document.getElementById('Eyesone').src = 'Layers/Faces/' + mood.fileName + '/Eyes//BlueRaspberry.png';
    }
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

getDate();


//Basic Functions
//Flip Coin Function 50/50
function flipCoin() {
    var randomNum = Math.floor(Math.random() * 2);
    if (randomNum === 0) {
        return false;
    } else {
        return true;
    }
}

//Choose From Array Function
function chooseFromArrayRandom(array) {
    var randomNum = Math.floor(Math.random() * array.length);
    return array[randomNum];
}

//Choose Randomly with any number
function randomNumber(num) {
    var randomNum = Math.floor(Math.random() * num);
    return randomNum;
}

//Random Number Check
function randomNumbercheck(number) {
    const randomNum = randomNumber(number);
    if (randomNum === 0) {
        return true
    } else {
        return false;
    }
}

//Check for Duplicates in Array
function checkIfDuplicateExists(arr) {
    return new Set(arr).size !== arr.length;
}

//Remove Duplicates in Array
function removeDuplicates(arr) {
    return arr.filter((item,
        index) => arr.indexOf(item) === index);
}

//MoodForm Stuff
function showForm() {
    document.getElementById('moodForm').style.display = 'block';
}
function hideForm() {
    const e = document.getElementById('moodSelect');
    const value = e.options[e.selectedIndex].value;
    var moodObject = findMoodByName(value);
    setMoodSelect(moodObject);
    document.getElementById('moodForm').style.display = 'none';
}
























