import '../assets/css/Footer.css';

const Footer = () => {
    return (
        <div className="footer">
            <footer>
                <p>&copy; 2024 Search Ranking Measurement System. All rights reserved.</p>
                <div className="links">
                    <button onClick={() => console.log('Privacy Policy clicked')}>Privacy Policy</button>
                    <button onClick={() => console.log('Terms of Service clicked')}>Terms of Service</button>
                    <button onClick={() => console.log('Contact Us clicked')}>Contact Us</button>
                </div>
            </footer>
        </div>
    );
}

export default Footer;
