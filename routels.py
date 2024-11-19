from flask import Blueprint, render_template, redirect, url_for, flash, request
from flask_login import login_user, logout_user, login_required, current_user
from app.model import db, User, Internship, Assignment
from app.forms import LoginForm, RegisterForm

main_bp = Blueprint('main', _name_)

@main_bp.route('/')
def home():
    return render_template('home.html')

@main_bp.route('/login', methods=['GET', 'POST'])
def login():
    form = LoginForm()
    if form.validate_on_submit():
        user = User.query.filter_by(email=form.email.data).first()
        if user and user.password == form.password.data:
            login_user(user)
            return redirect(url_for('main.dashboard'))
        flash('Invalid email or password')
    return render_template('login.html', form=form)

@main_bp.route('/register', methods=['GET', 'POST'])
def register():
    form = RegisterForm()
    if form.validate_on_submit():
        new_user = User(
            username=form.username.data,
            email=form.email.data,
            password=form.password.data,
            role=form.role.data
        )
        db.session.add(new_user)
        db.session.commit()
        flash('Account created successfully!')
        return redirect(url_for('main.login'))
    return render_template('register.html', form=form)

@main_bp.route('/dashboard')
@login_required
def dashboard():
    if current_user.role == 'student':
        internships = Internship.query.filter_by(student_id=current_user.id).all()
        return render_template('student_dashboard.html', internships=internships)
    elif current_user.role == 'faculty':
        # Faculty logic
        return render_template('faculty_dashboard.html')
    elif current_user.role == 'admin':
        # Admin logic
        return render_template('admin_dashboard.html')
    return redirect(url_for('main.home'))

@main_bp.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('main.home'))