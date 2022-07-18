const { exec } = require("child_process");
const { mainModule } = require("process");
const recordScreen = require('record-screen')
const ffmpeg = require('ffmpeg');
const sharp = require('sharp');
const tesseract = require("node-tesseract-ocr");
const config = {
  lang: "eng",
  oem: 1,
  psm: 3,
}

function cmd(script) {
  return new Promise((resolve, reject) => {
    exec(script, (error, stdout, stderr) => {
      if (error) {
        reject();
      }
      if (stderr) {
        // console.log(`stderr: ${stderr}`);
      }
      resolve();
      console.log(`stdout: ${stdout}`);
    });
  })
}

function awaitTime(time) {
  return new Promise((resolve, reject) => {
    setTimeout(() => {
      resolve();
    }, time)
  })
}

async function main() {
  cmd("scrcpy --stay-awake");
  await awaitTime(1000);
  await cmd("adb shell input touchscreen swipe 300 1000 300 500 100");
  await cmd("adb shell input tap 175 850");
  await cmd("adb shell input tap 360 1300");
  await cmd("adb shell input tap 360 1300");
  await cmd("adb shell input tap 175 850");
  await awaitTime(2000);
  await cmd("adb shell input touchscreen swipe 300 1000 300 500 100");
  await cmd("adb shell input touchscreen swipe 100 1000 500 1000 100");
  await cmd("adb shell input touchscreen swipe 100 1000 500 1000 100");
  await cmd("adb shell input touchscreen swipe 100 1000 500 1000 100");
  await cmd("adb shell input touchscreen swipe 500 1000 100 1000 100");
  await cmd("adb shell input tap 270 820");
  await awaitTime(10000);
  await takeScreen();
}

function takeScreen() {
  return new Promise((resolve, reject) => {
    const recording = recordScreen('test.mp4', {
      resolution: '1366x768' // Display resolution
    })
    recording.promise
      .then(result => {
        process.stdout.write(result.stdout)
        process.stderr.write(result.stderr)
        const extractFrames = require('ffmpeg-extract-frames')
        extractFrames({
          input: './test.mp4',
          output: './screenshot.jpg',
          offsets: [
            200
          ]
        }).then(() => {
          sharp('./screenshot.jpg')
            .extract({ left: 540, top: 130, width: 285, height: 550 })
            .toFile('./screenshot.new.jpg', function (err) {
              if (err) console.log(err);
              tesseract
                .recognize("screenshot.new.jpg", config)
                .then((text) => {
                  console.log("Result:", text/*.split("\n")[2]*/)
                  let val = text.match(/.*R\$.*/)[0];
                  if (val) {
                    val = val.split(' ')[1]
                  }
                  console.log(val)
                  resolve()
                })
                .catch((error) => {
                  console.log(error.message)
                })

            })
          console.log(2)
        })
      })
      .catch(error => {
        // Screen recording has failed
        console.error(error)
        reject();
      })

    setTimeout(() => recording.stop(), 300)
  })
}

main();
