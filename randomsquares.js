const colors = ['Amethyst', 'Banana', 'Basil', 'BeachRock', 'Beef', 'BellPepper', 'Berry', 'Blackberry', 'Blueberry', 'BlueMushroom', 'BlueRaspberry', 'Bubblegum', 'BurntToast', 'Cherry', 'Cinnamon', 'Cornflower', 'CottonCandy', 'Cranberry', 'Denim', 'Dewdrop', 'Eggplant', 'FruitSnack', 'Gold', 'Goldfish', 'GreenGrape', 'Guava', 'Gumdrop', 'Haunt', 'Holiday', 'HotChocolate', 'Icing', 'Ink', 'Iron', 'JellyBean', 'Juice', 'Kiwi', 'Latte', 'Lavender', 'Leaf', 'Lemon', 'Lime', 'Love', 'Mandarin', 'Marker', 'Marmalade', 'Mocha', 'Molasses', 'Night', 'Oatmeal', 'Olive', 'Orange', 'Papaya', 'Party', 'Pastel', 'Peach', 'Pillow', 'Pine', 'Plum', 'Potato', 'PurpleGrape', 'Rock', 'Sardine', 'Seafoam', 'Shell', 'Silver', 'Snow', 'SoftServe', 'Taffy', 'Tomato', 'Vanilla', 'Waterfall', 'Yarn'];
const hair = ['Floof', 'Wave', 'Mane', 'Mop'];
const tail = ['Dragon', 'Long', 'Nub', 'Poof'];
const face = ['Tongue'];
const clothes = ['None','None','None','None','None', 'HarnessTrans', 'HarnessBrown', 'HarnessPink', 'HarnessBlue', 'BandagesChest', 'ServiceVestBeige', 'ServiceVestBlue', 'ServiceVestPink', 'ServiceVestRed'];
const hats = ['None','None','None','None', 'FlowerCrownPastel', 'Glasses', 'Halo'];

function snoozeling() {
    this.mainColor = chooseColor();
    this.hairColor = chooseColor();
    this.hairType = chooseHairType();
    this.tailType = chooseTailType();
    this.nosecolor = chooseColor();
    this.eyeColor = chooseColor();
    this.faceShape = chooseFaceType();
    this.bellyMarking = flipCoin();
    this.spotsMarking = flipCoin();
    this.clothesBottom = chooseClothesBottom();
    this.clothesTop = chooseClothesTop();
    let randomNum = Math.floor(Math.random() * 2);
    if (randomNum === 0) {
        this.tailColor = this.mainColor;
    } else {
        this.tailColor = this.hairColor;
    }
    randomNum = Math.floor(Math.random() * 10)
    if (randomNum === 0) {
        this.angel = true;
    }
    randomNum = Math.floor(Math.random() * 4);
    if (randomNum === 0) {
        this.wings = true;
    }
}

function randomNumber() {
    var randomNum = Math.floor(Math.random() * 100);
    return randomNum;
}

function flipCoin() {
    var randomNum = Math.floor(Math.random() * 2);
    if (randomNum === 0) {
        return false;
    }
    else {
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
    } /* if else () {
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
    } */ else {
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
    if (snoozelingOne.faceShape === 'Tongue') {
        setMainColorPic('Face' + number, 'Layers/Faces/Tongue/', snoozelingOne.mainColor);
        document.getElementById('Eyes' + number).src = "";
    } else {
        setMainColorPic('Face' + number, 'Layers/Faces/' + snoozelingOne.faceShape + '/', snoozelingOne.mainColor);
        setMainColorPic('Eyes' + number, 'Layers/Faces/' + snoozelingOne.faceShape + '/', snoozelingOne.eyeColor);
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
    console.log(text);
    document.getElementById('date').innerHTML = text;
}

getDate();
