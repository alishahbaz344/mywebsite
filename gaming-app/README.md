# 🎮 GameHub - Full Stack Gaming Web App

A modern, full-stack gaming web application built with Laravel 11, featuring user authentication, game scoring, achievements, leaderboards, and a responsive design.

## ✨ Features

### 🎯 Core Gaming Features
- **Game Collection**: Multiple game categories (Puzzle, Arcade, Strategy, Educational)
- **Score Tracking**: Personal best scores and global leaderboards
- **Achievement System**: Unlock achievements based on gameplay
- **Real-time Gameplay**: Interactive games with live scoring
- **Progress Tracking**: Monitor gaming statistics and completion rates

### 👤 User Management
- **Authentication**: Secure login/register with Laravel Breeze
- **User Profiles**: Customizable gaming profiles with avatars
- **Privacy Controls**: Public/private profile settings
- **Gaming Statistics**: Comprehensive stats tracking

### 🎨 Modern UI/UX
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Dark Mode Support**: Toggle between light and dark themes
- **Gaming Theme**: Custom gradient backgrounds and gaming-focused design
- **Interactive Elements**: Hover effects, animations, and transitions

### 📊 Analytics & Leaderboards
- **Global Leaderboards**: Compete with other players
- **Personal Dashboard**: Track your gaming journey
- **Achievement Gallery**: Display unlocked achievements
- **Game Statistics**: Detailed analytics per game

## 🛠 Technology Stack

- **Backend**: Laravel 11 (PHP 8.4)
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: SQLite (configurable)
- **Authentication**: Laravel Sanctum + Breeze
- **Real-time**: Livewire (ready for WebSocket integration)
- **Build Tools**: Vite
- **Icons**: Emoji-based gaming icons

## 🚀 Installation

### Prerequisites
- PHP 8.4 or higher
- Composer
- Node.js & NPM

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd gaming-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build frontend assets**
   ```bash
   npm run build
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to start gaming!

## 🎮 Available Games

### 1. Number Guessing Game
- **Category**: Puzzle
- **Difficulty**: Easy
- **Description**: Guess a random number between 1-100
- **Scoring**: Based on number of guesses and time taken
- **Features**: 
  - 10 maximum guesses
  - Time bonus scoring
  - Guess history tracking
  - Real-time feedback

### 2. Other Games (Coming Soon)
- Snake Game (Arcade)
- Memory Match (Puzzle)  
- Tetris Clone (Puzzle)
- Flappy Bird Clone (Arcade)
- Math Quiz (Educational)
- Rock Paper Scissors (Strategy)
- Tic Tac Toe (Strategy)
- Word Scramble (Educational)
- Simon Says (Puzzle)

## 🏆 Achievement System

### Achievement Categories
- **Score-based**: Reach certain score thresholds
- **Play Count**: Play a certain number of games
- **Time-based**: Complete games within time limits
- **Category-specific**: Master specific game categories
- **Special**: Unique achievements for exceptional performance

### Rarity Levels
- **Common** (🟢): Basic achievements
- **Rare** (🔵): Challenging accomplishments  
- **Epic** (🟣): Difficult achievements
- **Legendary** (🟡): Elite-level achievements

## 📱 Responsive Design

The application is fully responsive with:
- **Mobile-first** approach
- **Flexible grid** layouts
- **Touch-friendly** controls
- **Optimized performance** on all devices

## 🗄 Database Schema

### Main Tables
- `users` - User accounts with gaming stats
- `games` - Game definitions and metadata
- `game_scores` - Individual game scores
- `achievements` - Achievement definitions
- `user_achievements` - User achievement unlocks

### Key Relationships
- Users have many GameScores
- Users belong to many Achievements
- Games have many GameScores
- Achievements belong to many Users

## 🔒 Security Features

- **CSRF Protection**: All forms protected
- **Input Validation**: Server-side validation
- **SQL Injection Prevention**: Eloquent ORM
- **Authentication**: Secure session management
- **Score Validation**: Anti-cheat measures

## 🎯 API Endpoints

### Game Management
- `GET /games` - List all games
- `GET /games/{game}` - Game details
- `GET /games/{game}/play` - Play game interface
- `POST /games/{game}/score` - Submit score

### User Dashboard
- `GET /dashboard` - User dashboard
- `GET /profile` - User profile
- `PATCH /profile` - Update profile

### Leaderboards
- `GET /leaderboard` - Global leaderboard
- `GET /achievements` - Achievement gallery

## 🚀 Performance Optimizations

- **Database Indexing**: Optimized queries
- **Eager Loading**: Reduced N+1 queries
- **Asset Optimization**: Minified CSS/JS
- **Caching Ready**: Cache-friendly architecture
- **CDN Ready**: Static asset optimization

## 🔧 Configuration

### Game Settings
Games can be configured in database seeders:
- Difficulty levels
- Time limits
- Scoring algorithms
- Game-specific parameters

### Achievement Settings
Achievements are configurable via database:
- Requirements criteria
- Point values
- Rarity levels
- Unlock conditions

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

### Test Coverage
- Feature tests for core functionality
- Unit tests for game logic
- Browser tests for UI interactions

## 📈 Future Enhancements

### Planned Features
- **Real-time Multiplayer**: WebSocket integration
- **Game Creation Tools**: User-generated content
- **Social Features**: Friend systems, game sharing
- **Mobile Apps**: Native iOS/Android apps
- **Advanced Analytics**: Detailed gaming insights

### Technical Improvements
- **Redis Caching**: Performance optimization
- **Queue System**: Background job processing
- **API Versioning**: RESTful API expansion
- **Microservices**: Scalable architecture

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🎉 Demo Accounts

For testing purposes, the following accounts are seeded:

**Test User**
- Email: `test@example.com`
- Password: `password`

**Admin User**  
- Email: `admin@example.com`
- Password: `password`

## 📞 Support

If you encounter any issues or have questions:
1. Check the documentation
2. Search existing issues
3. Create a new issue with detailed information

---

**Happy Gaming! 🎮**

Built with ❤️ using Laravel 11 and modern web technologies.
