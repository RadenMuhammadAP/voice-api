from flask import Flask, request, jsonify
import re

app = Flask(__name__)

# Fungsi cek apakah kalimat valid sebagai pertanyaan
def is_valid_question(sentence):
    sentence = sentence.strip().lower()

    # Harus diakhiri tanda tanya
    if not sentence.endswith('?'):
        return False

    # Kata tanya umum
    question_words = [
        'apa', 'siapa', 'kapan', 'dimana', 'di mana', 'mengapa', 'kenapa', 'bagaimana','berapa',
        'what', 'who', 'when', 'where', 'why', 'how', 'do', 'does', 'did', 'is', 'are', 'can', 'will'
    ]

    words = sentence.split()
    if len(words) < 3:
        return False

    if words[0] not in question_words:
        return False

    return True

@app.route('/is_question', methods=['POST'])
def check_question():
    data = request.get_json()
    sentence = data.get('sentence', '')
    result = is_valid_question(sentence)
    return jsonify({"is_question": result})

if __name__ == '__main__':
    app.run(port=5001, debug=True)
