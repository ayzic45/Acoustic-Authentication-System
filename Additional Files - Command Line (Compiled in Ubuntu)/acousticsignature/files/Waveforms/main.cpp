#include "ggwave/ggwave.h"

#define DR_WAV_IMPLEMENTATION
#include "dr_wav.h"

#include "ggwave-common.h"

#include <cstdio>
#include <cstring>
#include <iostream>

int main(int argc, char** argv) {
    printf("Acoustic Authentication System\n");
    printf("Generating Transmitted Waveforms\n");

    const auto & protocols = GGWave::getTxProtocols();
    for (const auto & protocol : protocols) {
    }
    fprintf(stderr, "\n");

    if (argc < 1) {
        return -1;
    }

    auto argm = parseCmdArguments(argc, argv);

    if (argm.find("h") != argm.end()) {
        return 0;
    }

    int volume = argm["v"].empty() ? 50 : std::stoi(argm["v"]);
    float sampleRateOut = argm["s"].empty() ? GGWave::kBaseSampleRate : std::stof(argm["s"]);
    int protocolId = argm["p"].empty() ? 1 : std::stoi(argm["p"]);
    int payloadLength = argm["l"].empty() ? -1 : std::stoi(argm["l"]);

    if (volume <= 0 || volume > 100) {
        fprintf(stderr, "Invalid volume\n");
        return -1;
    }

    if (sampleRateOut < GGWave::kSampleRateMin || sampleRateOut > GGWave::kSampleRateMax) {
        fprintf(stderr, "Invalid sample rate: %g\n", sampleRateOut);
        return -1;
    }

    if (protocolId < 0 || protocolId >= (int) GGWave::getTxProtocols().size()) {
        fprintf(stderr, "Invalid transmission protocol id\n");
        return -1;
    }

    fprintf(stderr, "Enter a string to to generate:\n");

    std::string message;
    std::getline(std::cin, message);

    if (message.size() == 0) {
        fprintf(stderr, "Invalid message: size = 0\n");
        return -2;
    }

    if (message.size() > 140) {
        fprintf(stderr, "Invalid message: size > 140\n");
        return -3;
    }

    fprintf(stderr, "Generating waveform for string '%s' ...\n", message.c_str());

    GGWave ggWave({ payloadLength, GGWave::kBaseSampleRate, sampleRateOut, 1024, GGWave::kDefaultSamplesPerFrame, GGWAVE_SAMPLE_FORMAT_F32, GGWAVE_SAMPLE_FORMAT_I16 });
    ggWave.init(message.size(), message.data(), ggWave.getTxProtocol(protocolId), volume);

    std::vector<char> bufferPCM;
    GGWave::CBWaveformOut cbWaveformOut = [&](const void * data, uint32_t nBytes) {
        bufferPCM.resize(nBytes);
        std::memcpy(bufferPCM.data(), data, nBytes);
    };

    if (ggWave.encode(cbWaveformOut) == false) {
        fprintf(stderr, "Failed to generate waveform!\n");
        return -4;
    }

    fprintf(stderr, "Output size = %d bytes\n", (int) bufferPCM.size());

    drwav_data_format format;
    format.container = drwav_container_riff;
    format.format = DR_WAVE_FORMAT_PCM;
    format.channels = 1;
    format.sampleRate = sampleRateOut;
    format.bitsPerSample = 16;

    fprintf(stderr, "Exporting waveform ...\n");

    drwav wav;
    drwav_init_file_write(&wav, "/dev/stdout", &format, NULL);
    drwav_uint64 framesWritten = drwav_write_pcm_frames(&wav, bufferPCM.size()/2, bufferPCM.data());

    drwav_uninit(&wav);

    return 0;
}
