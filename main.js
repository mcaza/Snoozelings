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
function Snoozeling(id, mainColor, eyeColor, hairColor, tailColor, noseColor, hairType, tailType, bellyMarking, spotsMarking, wings) {
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
    this.mood = chooseFromArrayRandom(moodList);
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
    const newSnooze = new Snoozeling(id, tempMainColor, tempEyecolor, tempHairColor, tempTailColor, tempNoseColor, tempHairType, tempTailType, tempBelly, tempSpots, tempWings);
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
    if (tempMainColor.colorRarity === 'Rare') {
        const chance = flipCoin();
        if (chance === true) {
            tempEyeColor = tempMainColor;
        } else {
            const randomNum = randomNumber(cleanEyes.length);
            tempEyeColor = cleanEyes[randomNum];
        }
    } else {
        const randomNum = randomNumber(cleanEyes.length);
        tempEyeColor = cleanEyes[randomNum];
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
    const babySnooze = new Snoozeling(id, tempMainColor, tempEyeColor, tempHairColor, tempTailColor, tempNoseColor, tempHairType, tempTailType, tempBellyMarking, tempSpotsMarking, tempWings);
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
        document.getElementById('Tail' + number).src = 'Layers/Tail/Dragon/End/' + snoozeling.hairColor.fileName;
        document.getElementById('SecondTail' + number).src = 'Layers/Tail/Dragon/' + snoozeling.mainColor.fileName;
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
    
}

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
