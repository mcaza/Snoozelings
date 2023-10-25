//Color Stuff
//Color Factory
function Color(id, array) {
    this.id = id;
    this.colorName = array[0];
    this.displayName = array[1];
    this.fileName = array[0] + '.png';
    this.colorRarity = array[2];
    this.colorCategories = array[3];
}

//Find Color Function
function findColorByName(color) {
    return colorList.find(x => x.colorName === color);
}

//Color Information
const colorArray = [
                    ['Amethyst', 'Amethyst', 'Common', ['Purple']],
                    ['Banana', 'Banana', 'Common', ['Yellow']],
                    ['Basil', 'Basil', 'Common', ['Green']],
                    ['BeachRock', 'Beach Rock', 'Common', ['Brown']],
                    ['Beef', 'Beef', 'Common', ['Brown', 'Red']],
                    ['BellPepper', 'Bell Pepper', 'Common', ['Red', 'Eyeburner']],
                    ['Berry', 'Berry', 'Common', ['Pink']],
                    ['Blackberry', 'Blackberry', 'Common', ['Blue', 'Dark']],
                    ['Blueberry', 'Blueberry', 'Common', ['Blue']],
                    ['BlueMushroom', 'Blue Mushroom', 'Common', ['Blue', 'Pastel']],
                    ['BlueRaspberry', 'Blue Raspberry', 'Common', ['Blue', 'Eyeburner']],
                    ['Bubblegum', 'Bubblegum', 'Common', ['Pink', 'Pastel']],
                    ['BurntToast', 'Burnt Toast', 'Common', ['Brown']],
                    ['Cherry', 'Cherry', 'Common', ['Red']],
                    ['Cinnamon', 'Cinnamon', 'Common', ['Brown']],
                    ['Cornflower', 'Cornflower', 'Common', ['Blue']],
                    ['CottonCandy', 'Cotton Candy', 'Uncommon', ['Pink', 'Purple', 'Blue', 'Pastel']],
                    ['Cranberry', 'Cranberry', 'Common', ['Red']],
                    ['Denim', 'Denim', 'Common', ['Blue', 'Pastel']],
                    ['Dewdrop', 'Dewdrop', 'Common', ['Blue', 'Pastel']],
                    ['Eggplant', 'Eggplant', 'Common', ['Purple']],
                    ['FruitSnack', 'Fruit Snack', 'Common', ['Blue']],
                    ['Gold', 'Gold', 'Common', ['Yellow']],
                    ['Goldfish', 'Goldfish', 'Common', ['Orange', 'Pastel']],
                    ['GreenGrape', 'Green Grape', 'Common', ['Green']],
                    ['Guava', 'Guava', 'Common', ['Yellow', 'Pastel']],
                    ['Gumdrop', 'Gumdrop', 'Common', ['Purple']],
                    ['Haunt', 'Haunt', 'Uncommon', ['Purple', 'Orange']],
                    ['Holiday', 'Holiday', 'Uncommon', ['Red', 'Green', 'Purple']],
                    ['HotChocolate', 'Hot Chocolate', 'Common', ['Brown']],
                    ['Icing', 'Icing', 'Common', ['Blue', 'Pastel']],
                    ['Ink', 'Ink', 'Common', ['Black', 'Monochrome', 'Dark']],
                    ['Iron', 'Iron', 'Common', ['Grey', 'Monochrome']],
                    ['JellyBean', 'Jelly Bean', 'Common', ['Blue', 'Eyeburner']],
                    ['Juice', 'Juice', 'Common', ['Red', 'Pastel']],
                    ['Kiwi', 'Kiwi', 'Common', ['Green']],
                    ['Latte', 'Latte', 'Common', ['Brown']],
                    ['Lavender', 'Lavender', 'Common', ['Purple', 'Pastel']],
                    ['Leaf', 'Leaf', 'Common', ['Green']],
                    ['Lemon', 'Lemon', 'Common', ['Yellow']],
                    ['Lime', 'Lime', 'Common', ['Green', 'Eyeburner']],
                    ['Love', 'Love', 'Common', ['Pink', 'Red']],
                    ['Mandarin', 'Mandarin', 'Common', ['Orange']],
                    ['Marker', 'Marker', 'Common', ['Pink', 'Eyeburner']],
                    ['Marmalade', 'Marmalade', 'Common', ['Orange']],
                    ['Mocha', 'Mocha', 'Common', ['Brown']],
                    ['Molasses', 'Molasses', 'Common', ['Brown']],
                    ['Night', 'Night', 'Common', ['Blue', 'Dark']],
                    ['Oatmeal', 'Oatmeal', 'Common', ['Brown', 'Pastel']],
                    ['Olive', 'Olive', 'Common', ['Green']],
                    ['Orange', 'Orange', 'Common', ['Orange']],
                    ['Papaya', 'Papaya', 'Common', ['Orange', 'Eyeburner']],
                    ['Party', 'Party', 'Common', ['Purple']],
                    ['Peach', 'Peach', 'Common', ['Orange', 'Pastel']],
                    ['Pillow', 'Pillow', 'Common', ['Purple']],
                    ['Pine', 'Pine', 'Common', ['Green']],
                    ['Plum', 'Plum', 'Common', ['Purple']],
                    ['Potato', 'Potato', 'Common', ['Brown']],
                    ['PurpleGrape', 'Purple Grape', 'Common', ['Purple']],
                    ['Rock', 'Rock', 'Common', ['Grey', 'Monochrome']],
                    ['Sardine', 'Sardine', 'Common', ['Grey', 'Monochrome']],
                    ['Seafoam', 'Seafoam', 'Common', ['Green', 'Pastel']],
                    ['Shell', 'Shell', 'Common', ['Pink', 'Purple', 'Pastel']],
                    ['Silver', 'Silver', 'Common', ['Grey', 'Monochrome']],
                    ['Snow', 'Snow', 'Common', ['White', 'Monochrome']],
                    ['Taffy', 'Taffy', 'Common', ['Pink', 'Purple']],
                    ['Tomato', 'Tomato', 'Common', ['Red']],
                    ['Vanilla', 'Vanilla', 'Common', ['Yellow']],
                    ['Waterfall', 'Waterfall', 'Common', ['Blue', 'Pastel']],
                    ['Yarn', 'Yarn', 'Common', ['Red', 'Pastel']],
                    ['Pastel', 'Pastel', 'Uncommon', ['Blue', 'Purple', 'Pastel']],
                    ['SoftServe', 'Soft Serve', 'Uncommon', ['Pink', 'Brown', 'White']],
                    ['Sloth', 'Sloth', 'Rare', ['Brown', 'Green']],
                    ['Bee', 'Bee', 'Rare', ['Yellow', 'Brown', 'White']],
                    ['Raccoon', 'Raccoon', 'Rare', ['Grey', 'White', 'Monochrome']],
                    ['RedPanda', 'Red Panda', 'Rare', ['Orange', 'White', 'Black']],
                    ['Retro', 'Retro', 'Rare', ['Black', 'Purple', 'Pink', 'Green', 'Eyeburner']]
                   ];

//Create Colors and add to color list
let colorList = [];
for (let i = 0; i < colorArray.length; i++) {
    const tempObject = new Color(i, colorArray[i]);
    colorList.push(tempObject);
}

//Return Colors by Rarity
function returnColorsByRarity(rarity) {
    let tempList = [];
    for (let i = 0; i < colorList.length; i++) {
        if (colorList[i].colorRarity === rarity) {
            tempList.push(colorList[i]);
        }
    }
    return tempList;
}

//Return Colors by SubColors
function returnColorsByCategory(category) {
    let tempList = [];
    for (let i = 0; i < colorList.length; i++) {
        for (let j = 0; j < colorList[i].colorCategories.length; j++) {
            if (colorList[i].colorCategories[j] === category) {
                tempList.push(colorList[i]);
            }
        }
    }
    return tempList;
}

//Choose Random Common Color Function
function chooseByColorRarity(rarity) {
    const tempArray = returnColorsByRarity(rarity);
    const choice = Math.floor(Math.random() * tempArray.length);
    return tempArray[choice];
}

//Emotion Stuff
//Emotion Factory
function Mood(id, array) {
    this.id = id;
    this.moodName = array[0];
    this.fileName = array[1];
    this.colors = array[2];
}

//Create Moods
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

//Create Moods and add to mood list
let moodList = [];
for (let i = 0; i < moodArray.length; i++) {
    const tempObject = new Mood(i, moodArray[i]);
    moodList.push(tempObject);
}

//Find Mood By Name Function
function findMoodByName(name) {
    return moodList.find(x => x.moodName === name);
}

//Snoozeling Stuff
//Array Stuff
const hairTypes = ['Floof', 'Wave', 'Mane', 'Mop', 'Flowing'];
const tailTypes = ['Dragon', 'Long', 'Nub', 'Poof'];

//Choose Hair Color Function
function chooseHairColor(tempMainColor) {
    if (tempMainColor.colorRarity === 'Rare') {
        const tempNumber = flipCoin();
        if (tempNumber === true) {
            return tempMainColor;
        } else {
            return chooseByColorRarity('Common');
        }
    } else {
        return chooseByColorRarity('Common');
    }
}

//Choose Tail Color Function
function chooseTailColor(tempHairColor) {
    const randomChance = flipCoin();
    if (tempHairColor.colorRarity === 'Rare' || randomChance === true) {
        return tempHairColor;
    } else {
        return chooseByColorRarity('Common');
    }
}

//Snoozeling Factory
function Snoozeling(id, mainColor, eyeColor, hairColor, tailColor, noseColor, hairType, tailType, bellyMarking, spotsMarking, wings, mood) {
    this.id = id;
    this.mainColor = mainColor;
    this.eyeColor = eyeColor;
    this.hairColor = hairColor;
    this.tailColor = tailColor;
    this.noseColor = noseColor;
    this.hairType = hairType;
    this.tailType = tailType;
    this.bellyMarking = bellyMarking;
    this.spotsMarking = spotsMarking;
    this.wings = wings;
    this.mood = mood;
    this.faceType = this.mood.fileName;
    if (this.mood.colors === true) {
        this.faceColor = this.mood.fileName;
    } else {
        this.faceColor = "";
    }
}

function randomSnoozeling(id) {
    const tempMainColor = chooseFromArrayRandom(colorList);
    const tempEyecolor = chooseByColorRarity('Common');
    const tempHairColor = chooseHairColor(tempMainColor);
    const tempTailColor = chooseTailColor(tempHairColor);
    const tempTailType = chooseFromArrayRandom(tailTypes);
    const tempHairType = chooseFromArrayRandom(hairTypes);
    const tempNoseColor = chooseFromArrayRandom(colorList);
    const tempBelly = flipCoin();
    const tempSpots = flipCoin();
    const tempWings = randomNumbercheck(4);
    const tempMood = chooseFromArrayRandom(moodList);
    const newSnooze = new Snoozeling(id, tempMainColor, tempEyecolor, tempHairColor, tempTailColor, tempNoseColor, tempHairType, tempTailType, tempBelly, tempSpots, tempWings, tempMood);
    return newSnooze;
}

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
}

//Set Snoozeling on Page
function putSnoozelingOnPage(number, snoozeling) {
    document.getElementById('Primary' + number).src = 'Layers/Primary/' + snoozeling.mainColor.fileName;
    document.getElementById('MainLines' + number).src = 'Layers/MainLines/' + snoozeling.mainColor.fileName;
    if (snoozeling.spotsMarking === true) {
        document.getElementById('Spots' + number).src = 'Layers/Markings/Spots/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('Spots' + number).src = '';
    }
    if (snoozeling.bellyMarking === true) {
        document.getElementById('Belly' + number).src = 'Layers/Markings/Belly/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('Belly' + number).src = '';
    }
    if (snoozeling.wings === true) {
        document.getElementById('BottomWing' + number).src = 'Layers/Wings/Pegasus/Bottom/' + snoozeling.mainColor.fileName;
        document.getElementById('TopWing' + number).src = 'Layers/Wings/Pegasus/Top/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('BottomWing' + number).src = '';
        document.getElementById('TopWing' + number).src = '';
    }
    if (snoozeling.hairType === 'Floof') {
        document.getElementById('Hair' + number).src = 'Layers/Hair/' + snoozeling.hairType + '/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('Hair' + number).src = 'Layers/Hair/' + snoozeling.hairType + '/' + snoozeling.hairColor.fileName;
    }

    if (snoozeling.tailType === 'Dragon') {
        document.getElementById('SecondTail' + number).src = 'Layers/Tail/Dragon/End/' + snoozeling.hairColor.fileName;
        document.getElementById('Tail' + number).src = 'Layers/Tail/Dragon/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('Tail' + number).src = 'Layers/Tail/' + snoozeling.tailType + '/' + snoozeling.tailColor.fileName;
        document.getElementById('SecondTail' + number).src = '';
    }
    if (snoozeling.mood.fileName === 'Silly') {
        document.getElementById('Eyes' + number).src = '';
        document.getElementById('Face' + number).src = 'Layers/Faces/' + snoozeling.mood.fileName + '/' + snoozeling.mainColor.fileName;
    } else {
        document.getElementById('Eyes' + number).src = 'Layers/Faces/' + snoozeling.mood.fileName + '/Eyes/' + snoozeling.eyeColor.fileName;
        document.getElementById('Face' + number).src = 'Layers/Faces/' + snoozeling.mood.fileName + '/Lines/' + snoozeling.mainColor.fileName;
    }
    document.getElementById('Nose' + number).src = 'Layers/Noses/' + snoozeling.noseColor.fileName;
    document.getElementById('Transparent' + number).src = 'Layers/transparentSquare.png';
}

//Set Snoozeling Information on Profile
function profileInfo(snoozeling) {
    document.getElementById('pbmaincolor').innerHTML = "<strong>Main Color: </strong>" + snoozeling.mainColor.displayName;
    document.getElementById('pbhaircolor').innerHTML = "<strong>Hair Color: </strong>" + snoozeling.hairColor.displayName;
    document.getElementById('pbeyecolor').innerHTML = "<strong>Eye Color: </strong>" + snoozeling.eyeColor.displayName;
    document.getElementById('pbnosecolor').innerHTML = "<strong>Nose Color: </strong>" + snoozeling.noseColor.displayName;
    document.getElementById('pbhairstyle').innerHTML = "<strong>Hair Style: </strong>" + snoozeling.hairType;
    document.getElementById('pbtailstyle').innerHTML = "<strong>Tail Type: </strong>" + snoozeling.tailType;
    specialMarkings(snoozeling);
}

//Display Special Markings
function specialMarkings(snoozeling) {
    let markingsString = "<strong>Special Traits: </strong><ul style='text-align: left;margin-top: 0;'>";
    const itemsArray = [snoozeling.wings, snoozeling.bellyMarking, snoozeling.spotsMarking];
    const nameArray = ['Wings', 'Belly Marking', 'Body Scales'];
    let trueArray = [];
    for (let i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i]) {
            trueArray.push(nameArray[i]);
        }
    }
    for (let i = 0; i < trueArray.length; i++) {
        markingsString = markingsString + '<li>' + trueArray[i] + '</li>';
    }
    markingsString = markingsString + '</ul>';
    document.getElementById('pbspecialmarkings').innerHTML = markingsString;
}

//Display Snoozeling (Left and Large)
function petPageCode() {
    var testSnooze = new randomSnoozeling(0);
    putSnoozelingOnPage('one', testSnooze);
    putSnoozelingOnPage('large', testSnooze);
    profileInfo(testSnooze);
}


//Breed Snoozeling Babies
let snoozeOne = {};
let snoozeTwo = {};

function newMom() {
    snoozeOne = randomSnoozeling(0);
    putSnoozelingOnPage('one', snoozeOne);
}

function newDad() {
    snoozeTwo = new randomSnoozeling(1);
    putSnoozelingOnPage('two', snoozeTwo);
}

function breedCode() {
    const babyOne = new breedSnoozeling(snoozeOne, snoozeTwo, 2);
    const babyTwo = new breedSnoozeling(snoozeOne, snoozeTwo, 3);
    const babyThree = new breedSnoozeling(snoozeOne, snoozeTwo, 4);
    const babyFour = new breedSnoozeling(snoozeOne, snoozeTwo, 5);
    putSnoozelingOnPage('1', babyOne);
    putSnoozelingOnPage('2', babyTwo);
    putSnoozelingOnPage('3', babyThree);
    putSnoozelingOnPage('4', babyFour);
}

//Affirmations
const affirmations = ['I am in the right place at the right time, doing the right thing.', 'Every decision I make is supported by my whole and inarguable experience.', 'I am allowed to ask for what I want and what I need.', 'I am allowed to feel good.', 'I am complete as I am, others simply support me.', 'I am growing and I am going at my own pace.', 'I am held and supported by those who love me.', 'I am open to healing.', 'I am optimistic because today is a new day.', 'I am still learning so it’s okay to make mistakes.', 'I am worthy of investing in myself.', 'I belong here, and I deserve to take up space.', 'I can be soft in my heart and firm in my boundaries.', 'I can hold two opposing feelings at once, it means I am processing.', 'I deserve self-respect and a clean space.', 'I embrace the questions in my heart and welcome the answers in their own time.', 'I have come farther than I would have ever thought possible, and I’m learning along the way.', 'I look forward to tomorrow and the opportunities that await me.', 'I strive for joy, not for perfection.', 'I welcome the wisdom that comes with growing older.', 'My body is beautiful in this moment and at its current size.', 'My life is not a race or competition.', 'My perspective is unique and important.', 'My weirdness is wonderful.', 'There is room for me at the table.', 'Today is an opportunity to grow and learn.', 'Words may shape me, but they do not make me. I am here already.', 'I am loved just for being who I am, just for existing.', 'The chance to love and be loved exists no matter where I am.', 'I am deliberate and afraid of nothing.', 'My life is about to be incredible.', 'My perspective is unique. It\'s important and it counts.', 'I\'m better than I used to be. Better than I was yesterday. But hopefully not as good as I\'ll be tomorrow.', 'I give myself permission to root for myself.', 'I will embrace the glorious mess that I am.', 'Failure is just another way to learn how to do something right.', 'I am getting better and better every day.', 'I am an unstoppable force of nature.', 'I am not pushed by my problems; I am led by my dreams.', 'I can be whatever I want to be.', 'I am not defined by my past; I am driven by my future.', 'I am constantly growing and evolving into a better person.', 'I am going to forgive myself and free myself. I deserve to forgive and be forgiven.', 'I\'ve made it through hard times before, and I\'ve come out stronger and better because of them. I\'m going to make it through this', 'I belong in this world; there are people that care about me and my worth.', 'My past may be ugly, but I am still beautiful.', 'I have made mistakes, but I will not let them define me.', 'I don\'t compare myself to others. The only person I compare myself to is the person I was yesterday. And as long as the person I am today is even the tiniest bit better than the person I was yesterday—I’m meeting my own definition of success.', 'I finish what matters and let go of what does not.', 'My life has meaning. What I do has meaning. My actions are meaningful and inspiring.', 'What I have done today was the best I was able to do today. And for that, I am thankful.', 'Happiness is a choice, and today I choose to be happy.', 'I have done difficult things in the past, and I can do them again.', 'I am allowed to feel upset, angry, and sad sometimes—that’s part of being human.', 'My personal boundaries are important and I’m allowed to express my needs to others.', 'I am allowed to take up space, to have desires, and to have a voice', 'All this hard work I am putting into achieving my goals will pay off.', 'Growth is sometimes bumpy and isn’t always linear, but I will stay the course.', 'In my uniqueness, I find strength. I am enough.', 'Every day, I learn. Every day, I grow.', 'Breathe. Trust. Live.', 'Focus on what I can control; release the rest.', 'I am not what happened to me. I am what I choose to become.', 'People will forget what I said, people will forget what I did, but people will never forget how I made them feel.', 'Every day, in my own way, I am becoming more successful.', 'I belong here. ', 'I add value to people\'s lives.', 'I am worthy of love and belonging.', 'My measure of success is my own. I don’t need to compare myself to others.', 'I\'m empowered to choose what’s best for me.', 'I accept and express my emotions with an open heart.', 'I am strong, resilient, and not too proud to ask for help.', 'I\'m worthy, loved, and enough.', 'I accept myself for who I am, including my strengths and flaws.', 'Practice makes progress.', 'I can learn anything I put my mind to.', 'It\'s okay to ask for help when I need it.', 'Life is tough, but so am I.', 'I don\'t always know what others are going through, so I will be kind.', 'I don’t need to be perfect. I’m only human.', 'My past does not define my future.', 'I can face my fears one step at a time.', 'I trust myself to take the next best step.', 'Courage is not the absence of fear. Courage is doing it despite my fear.', 'I’m excited about what\'s to come.', 'Today is full of opportunities.', 'I will make the most of today.', 'I did my best today.', 'I\'m proud of what I accomplished today.', 'My to-do list will be there in the morning; tonight, I rest.', 'I forgive myself for what did not go well.', 'I strive to do my best.', 'The more I learn, the more I can accomplish.', 'Learning is a journey and an adventure.', 'It\'s okay not to know everything—there’s always something to learn.', 'Failure is not fatal, and success is not final.', 'My body is worthy of kindness and care.', 'I\'m worthy of self-care daily.', 'It is okay to feel fragile, sensitive, alone, and sad. These feelings are part of being a human being.', 'I am peaceful. I am calm. I am resilient in the midst of change.', 'I do my best daily and let the future take care of itself.', 'I have gotten over every bad day so far. I will get through this one.', 'I focus on what\'s before me, one step at a time.', 'I accept both the ups and downs as valuable parts of my life.', 'I focus on being the healthiest version of myself at this moment.', 'I am investing in my health because I know I am worth it.', 'I listen to my body. My body knows what it needs.', 'My creativity knows no bounds.', 'I trust my creative instincts and follow my intuition.', 'My creativity grows with each day and each experience.', 'My creativity is a gift that I share with the world.', 'I am a winner, both in spirit and in action.', 'I allow myself to feel my grief and heal at my own pace.', 'My pain is real, but so is my resilience.', 'It\'s okay to seek help and share my feelings.', 'I belong, I am worthy, and I deserve lovely days.', 'I may be a mess, but I\'m doing my best.', 'I am absolutely "good enough" today.', 'I\'s okay to be unsure. It\'s okay to make mistakes. Every day that I try matters.', 'I will be on my own side today', 'Things will keep changing, and everyday I\'m trying, I continue to level up.', 'It\'s good that I exist.', 'I don\'t need to know how to fix everything today. Just figuring out my next step is enough.', 'It\'s okay to focus on getting through today', 'Even when I am feeling awful, I deserve nice things.', 'I am worthy of kindness and care.', 'My life is not impossible; it\'s just a difficult moment.', 'I have an amazing record of surviving difficult things.', 'I am not a burden; I am a person with needs, and that\'s completely normal.', 'These difficult days won\'t consume my whole existence. I have a lot of good life left to live.', 'I have survived 100% of my life. I can handle whatever happens.', 'Difficult days always end. I can do this.', 'I can get myself through this.', 'I am absolutely worth caring for.', 'It\'s enough to just get myself through today.', 'I don\'t need to be perfect. Messy, weird me is enough.', 'I\'m still a good "me", even when I\'m not feeling like myself.', 'A string of bad days does not equal a bad life; things can change.', 'I don\'t need to qualify my existence. I am allowed to take up space.', 'I\'m doing what I can, and that is enough.', 'I don\'t need to try to fix everything today, I can just change one thing and see how that goes.', 'My needs make sense. My limits make sense.', 'I deserve a place in this world just as I am.', 'I can take today on one small thing at a time.', 'It\'s okay to not please everyone.', 'Times are touch, but you are, too.', 'i\'m not being lazy. I\'m overwhelmed and recharging.', 'Small steps still count.', 'I matter and I always will.', 'It\'s truly impressive how far I\'ve come.', 'Bad days do not erase my progress.', 'I am good enough, I always have been.', 'I deserve recharge time.', 'This feeling will pass. I\'m not stuck here forever.', 'I may not know what the future holds, but I can handle today.', 'I\'ve survived a ton of bad days; I got this.', 'The amount of recharge time I need is entirely reasonable.', 'I am far more resilient and capable than my anxiety gives me credit for.', 'I don\'t need to be perfect to be lovable.', 'My future is worth seeing.', 'You don\'t need to solve all your problems today; it\'s enough to just make it through.', 'I will not shame myself for difficult days.', 'When it\'s hard to find kindness, I will make it myself.', 'Healing takes time, and that\'s okay.', 'My efforts will pay off in time.', 'Your body is doing it\'s best and deserves kindness today.', 'I can be grateful and depressed at the same time. I am not a bad person for struggling to find joy in things right now.'];

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

//const bredSnoozeling = breedSnoozeling(snoozeOne, snoozeTwo, 2);
//console.log(bredSnoozeling);

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

function setMainColorPic(type, file, mainColor) {
    const link = file + mainColor + ".png";
    document.getElementById(type).src = link;
}
