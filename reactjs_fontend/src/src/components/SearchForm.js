// src/components/SearchForm.js
import React from "react";
import Button from "./Button";

const SearchForm = ({
    url, keywords, isValid, error, isButtonDisabled, handleInputChange, handleSearch, handleReset, setUrl
}) => (
    <div className="input-section">
        <div className="form-group">
            <label>
                URL <span style={{ color: "red" }}>*</span>
                <input
                    name="inputURL"
                    required
                    value={url}
                    onChange={(e) => setUrl(e.target.value)}
                />
            </label>
            {!isValid && <p style={{ color: 'red' }}>Invalid domain</p>}
        </div>
        <div className="form-group" style={{ marginTop: "20px" }}>
            <label>
                Keywords <textarea value={keywords} onChange={handleInputChange} rows="6" cols="40" />
            </label>
            {error && <p style={{ color: "red" }}>{error}</p>}
        </div>
        <div>
            <Button onClick={handleSearch} disabled={isButtonDisabled}>Search</Button>
            <Button onClick={handleReset}>Reset</Button>
        </div>
    </div>
);

export default SearchForm;
