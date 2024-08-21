// src/pages/SearchPage.js
import React, { useState } from "react";
import '../assets/css/SearchPage.css';
import SearchForm from "../components/SearchForm";
import useKeywordValidation from "../hooks/useKeywordValidation";

const SearchPage = () => {
    const [data, setData] = useState(null);
    const [keywords, setKeywords] = useState("");
    const [url, setUrl] = useState("");
    const [isValid, setIsValid] = useState(true);
    const { error, isButtonDisabled, validateKeywords } = useKeywordValidation();

    const isValidDomain = (domain) => {
        const domainPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]{1,63}\.[a-zA-Z]{2,}$/;
        return domainPattern.test(domain);
    };

    const handleSearch = () => {
        let check = isValidDomain(url);
        setIsValid(check);
        if (!check) return;

        const params = new URLSearchParams();
        const trimmedText = keywords.endsWith('\n') ? keywords.slice(0, -1) : keywords;
        trimmedText.split("\n").forEach(item => params.append('query[]', encodeURIComponent(item)));

        fetch(`http://localhost:8000/api/search?url=${url}&${params}`)
            .then(res => res.json())
            .then(data => setData(data));
    };

    const handleReset = () => {
        setData(null);
        setKeywords("");
        setUrl("");
        setIsValid(true);
    };

    const handleInputChange = (e) => {
        const value = e.target.value;
        setKeywords(value);
    
        // Thực hiện validate
        validateKeywords(value);
    };

    return (
        <div className="body-contents">
            <SearchForm
                url={url}
                keywords={keywords}
                isValid={isValid}
                error={error}
                isButtonDisabled={isButtonDisabled}
                handleInputChange={handleInputChange}
                handleSearch={handleSearch}
                handleReset={handleReset}
                setUrl={setUrl}
            />
            {data && (
                <div className="result-section">
                    <table id="table-result">
                        <thead>
                            <tr>
                                <th rowSpan="2">Keyword</th>
                                <th colSpan="2">Google</th>
                                <th colSpan="2">Yahoo</th>
                            </tr>
                            <tr>
                                <th>Rank</th>
                                <th>Search <br /> Results</th>
                                <th>Rank</th>
                                <th>Search <br /> Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            {Object.keys(data).map((key) => (
                                <tr key={key}>
                                    <td>{key}</td>
                                    <td>{data[key].google.ranking}</td>
                                    <td>{data[key].google.totalResult}</td>
                                    <td>{data[key].yahoo.ranking}</td>
                                    <td>{data[key].yahoo.totalResult}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
};

export default SearchPage;
