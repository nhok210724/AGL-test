import './assets/css/App.css';
import SearchPage from './pages/SearchPage.js'
import Header from './components/Header.js';
import Footer from './components/Footer.js';

function App() {
  return (
    <div className="App">
      <Header/>
      <SearchPage/>
      <Footer/>
    </div>
  );
}

export default App;
