// src/hooks/useKeywordValidation.js
import { useState } from "react";

const useKeywordValidation = () => {
    const [error] = useState("");
    const [isButtonDisabled, setIsButtonDisabled] = useState(true);

    const validateKeywords = (input) => {
        setIsButtonDisabled(false);

        if (input.length === 0) {
            setIsButtonDisabled(true);
            return "";
        }

        const keywordList = input.split("\n");
        keywordList.map(line =>
            line.length > 255 ? line.slice(0, 255) : line
        );

        if (keywordList.length > 5) {
            setIsButtonDisabled(true);
            return "You can only enter up to 5 keywords.";
        }

        return "";
    };

    return { error, isButtonDisabled, validateKeywords };
};

export default useKeywordValidation;
