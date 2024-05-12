from flask import Flask, request
import pyautogui

app = Flask(__name__)

@app.route('/press', methods=['POST'])
def handle_button_press():
    key = request.form['key']

    if key == 'W':
        pyautogui.press('up')
    elif key == 'S':
        pyautogui.press('down')
    elif key == 'A':
        pyautogui.press('left')
    elif key == 'D':
        pyautogui.press('right')
    elif key == 'E':
        pyautogui.press('enter')


    return 'OK'

if __name__ == '__main__':
    # app.run(debug=True)
    app.run(debug=True, host='0.0.0.0', port=5000)