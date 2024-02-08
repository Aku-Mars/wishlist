from flask import Flask, render_template, request, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
import secrets

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://mars:Mars123//@localhost/wishlist_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.secret_key = secrets.token_hex(16)

db = SQLAlchemy(app)

class Wishlist(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    item = db.Column(db.String(100), nullable=False)
    completed = db.Column(db.Boolean, default=False)

def create_app():
    with app.app_context():
        db.create_all()

create_app()

@app.route('/')
def index():
    wishlist = Wishlist.query.all()
    return render_template('index.html', wishlist=wishlist)

@app.route('/add', methods=['POST'])
def add():
    if request.method == 'POST':
        item = request.form['item']
        new_wishlist = Wishlist(item=item)
        db.session.add(new_wishlist)
        db.session.commit()
        flash('Wishlist berhasil ditambahkan', 'success')
    return redirect(url_for('index'))

@app.route('/complete/<int:wishlist_id>')
def complete(wishlist_id):
    wishlist = Wishlist.query.get(wishlist_id)
    if wishlist:
        wishlist.completed = not wishlist.completed
        db.session.commit()
        flash('Status wishlist berhasil diubah', 'success')
    else:
        flash('Wishlist tidak ditemukan', 'error')
    return redirect(url_for('index'))

@app.route('/delete/<int:wishlist_id>')
def delete(wishlist_id):
    wishlist = Wishlist.query.get(wishlist_id)
    if wishlist:
        db.session.delete(wishlist)
        db.session.commit()
        flash('Wishlist berhasil dihapus', 'success')
    else:
        flash('Wishlist tidak ditemukan', 'error')
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=4000)
